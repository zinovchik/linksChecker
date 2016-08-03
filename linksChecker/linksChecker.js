document.addEventListener("DOMContentLoaded", function (event) {

    var path_ajax_file = linksCheckerPath + '/linksChecker/ajaxLinksChecker.php';

    var links_array = document.querySelectorAll("a");
    var img_array = document.querySelectorAll("img");

    console.log(' * On page - Links: ' + links_array.length + ', Images: ' + img_array.length);

    if (links_array) {
        for (var i = 0; i < links_array.length; i++) {

            if (links_array[i].href != '') {
                httpGet(path_ajax_file + "?url=" + links_array[i].href)
                    .then(
                    function (response) {
                        if (response != '') {
                            console.log(response);
                        }
                    },
                    function (error) {
                        console.warn("Rejected: " + links_array[i].href);
                    }
                );
            }
        }
    }

    if(img_array) {
        for (var i = 0; i < img_array.length; i++) {

            if (img_array[i].src != '') {
                httpGet(path_ajax_file + "?url=" + img_array[i].src)
                    .then(
                    function (response) {
                        if (response != '') {
                            console.log(response);
                        }
                    },
                    function (error) {
                        console.info("Rejected: " + img_array[i].src);
                    }
                );
            }
        }
    }

    function httpGet(url) {

        return new Promise(function (resolve, reject) {

            var xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);

            xhr.onload = function () {
                if (this.status == 200) {
                    resolve(this.response);
                } else {
                    var error = new Error(this.statusText);
                    error.code = this.status;
                    reject(error);
                }
            };

            xhr.onerror = function () {
                reject(new Error("Network Error"));
            };

            xhr.send();
        });
    }
});
