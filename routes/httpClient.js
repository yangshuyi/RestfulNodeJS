var http = require('http');
var querystring = require('querystring');
var rp = require('request-promise');

var express = require('express');
var router = express.Router();


/* GET listing. */
router.post('/post', function (httpClientReq, httpClientRes, next) {
    var url = httpClientReq.query.url;
    var opt = {
        host: 'www.baidu.com',
        port: '80',
        method: 'POST',
        path: '/',
        headers: {}
    };

    var req = http.request(opt, function (res) {
        //不断的获取返回的数据
        res.on('data', function (chunk) {
            var response = ""+chunk;
            console.log(response);
            httpClientRes.send(response);
        });

        //监听等待响应结束事件，这时，就可以取到完整的返回数据。
        res.on('end', function () {
            console.log('No more data in response.')
        });
    });

    httpClientRes.on('error', function (e) {
        httpClientRes.send(e.message);
    });

    req.end();
});

/* Get listing. */
router.get('/getWithHttpGet', function (httpClientReq, httpClientRes, next) {
    http.get('http://www.baidu.com', function (res) {
        console.log("Got response: " + res.statusCode);
        // consume response body
        res.resume();

        res.on('data', function (chunk) {
            console.log(""+chunk);
            httpClientRes.send("" + chunk);
        });
    }).on('error', function (e) {
        console.log("Got error: " + e.message);
    });
});

/* Get listing. */
router.get('/getWithRP', function (httpClientReq, httpClientRes, next) {
    var options = {uri:'http://www.baidu.com',port:'80'};
    rp(options).then(function(html){
        httpClientRes.send(html);
    }).catch(function(ex){
        console.log(ex);
    });
});
module.exports = router;
