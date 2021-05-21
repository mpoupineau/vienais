<?php


namespace App\Manager;

use App\Entity\Order;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;

class PaypalManager
{
    public static function client()
    {
        return new PayPalHttpClient(self::environment());
    }

    public static function environment()
    {
        $clientId = getenv("CLIENT_ID");
        $clientSecret = getenv("CLIENT_SECRET");

        if ('sandbox' === getenv("PAY_ENV")) {
            return new SandboxEnvironment($clientId, $clientSecret);
        }

        return new ProductionEnvironment($clientId, $clientSecret);
    }


    /**
     * @param Order $order
     * @param string $successUrl
     * @param string $cancelUrl
     * @return array
     * @throws \Exception
     */
    public static function getOrderPage(Order $order, $successUrl, $cancelUrl)
    {
        $response = self::client()->execute(self::constructRequest($order, $successUrl, $cancelUrl));

        $links = $response->result->links;
        foreach ($links as $link) {
            if ('approve' === $link->rel) {
                return [
                    "orderPage" => $link->href,
                    "paypalOrderId" => $response->result->id
            ];
            }
        }

        throw new \Exception('Unable to get Paypal order page');
    }

    private static function constructRequest(Order $order, $successUrl, $cancelUrl)
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "amount" => [
                    "value" => $order->getPrice(),
                    "currency_code" => "EUR"
                ]
            ]],
            "application_context" => [
                "cancel_url" => $cancelUrl,
                "return_url" => $successUrl,
                "brand_name" => "Domaine des Vienais",
                "landing_page" => "BILLING",
                "shipping_preference" => "NO_SHIPPING",
                "user_action" =>  "PAY_NOW"
            ],
            "payer" => [
                "name" => [
                    "given_name" => $order->getDeliveryAddress()->getFirstname(),
                    "surname" => $order->getDeliveryAddress()->getLastname()
                ],
                "email_address" => $order->getDeliveryAddress()->getEmail(),
                "address" => [
                    "address_line_1" => $order->getDeliveryAddress()->getAddress(),
                    "address_line_2" => $order->getDeliveryAddress()->getAddressComplement(),
                    "admin_area_2" => $order->getDeliveryAddress()->getCity(),
                    "postal_code" => $order->getDeliveryAddress()->getZipcode(),
                    "country_code" => "FR"
                ]
            ]
        ];

        return $request;
    }


    public static function getOrder($orderId)
    {
        $request = new OrdersGetRequest($orderId);

        return self::client()->execute($request);
    }

    public static function captureOrder($orderId)
    {
        $request = new OrdersCaptureRequest($orderId);
        $request->prefer('return=representation');

        return self::client()->execute($request);
    }
}