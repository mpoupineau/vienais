page_path_less="public/client/less/page/"
page_path_css="public/client/css/page/"

lessc public/client/less/main.less public/client/css/main.css
echo "generate css file : public/client/css/main.css"

lessc public/client/less/theme/main.less public/client/theme/css/main.css
echo "generate css file : public/client/theme/css/main.css"

lessc public/client/less/theme/util.less public/client/theme/css/util.css
echo "generate css file : public/client/theme/css/util.css"

for line in $(find ${page_path_less} -iname '*.less'); do
     file="$(echo "${line##*/}" | cut -f 1 -d '.')"
     lessc ${page_path_less}${file}.less ${page_path_css}${file}.css
     echo "generate css file : ${page_path_css}${file}.css"
done