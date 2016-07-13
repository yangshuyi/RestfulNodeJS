var http = require('http');
var querystring = require('querystring');

var express = require('express');
var router = express.Router();

// redis 链接
var redis   = require('redis');
 // var client  = redis.createClient('6379', '192.168.200.8');
var client  = redis.createClient('6379', '127.0.0.1');

client.on("connect", function() {
    console.log("connect");
});

// redis 链接错误
client.on("error", function(error) {
    console.log(error);

});


/* Get listing. */
router.get('/', function (request, response, next) {
    var result = {code:1,message:'success',data: null};

    client.keys('*', function (error, keys) {
        if (error){
            result.code = -1;
            result.message = error;
            response.send(result);
        } else{
            result.data = keys;
            response.send(result);
        }
    });
});

router.get('/:key', function (request, response, next) {
    var key = request.param('key');
    var result = {code:1,message:'success',data: null};

    redis.get(key, function(error, value) {
        if (error){
            result.code = -1;
            result.message = error;
            response.send(result);
        } else{
            result.data = value;
            response.send(result);
        }
    });
});


router.post('/delete', function (request, response, next) {
    var key = request.param('key');
    var result = {code:1,message:'success',data: null};

    client.delete(key, function (err, o) {
        if (error){
            result.code = -1;
            result.message = error;
            response.send(result);
        } else{
            result.data = o;
            response.send(result);
        }
    });
});

module.exports = router;
