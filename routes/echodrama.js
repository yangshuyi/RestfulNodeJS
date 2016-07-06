var http = require('http');
var querystring = require('querystring');

var express = require('express');
var router = express.Router();


var mysql = require('mysql');  //调用MySQL模块(felixge/node-mysql)
//创建一个connection
var connection = mysql.createConnection({
    host: 'localhost',       //主机
    database: 'ysys',
    user: 'root',               //MySQL认证用户名
    password: '',        //MySQL认证用户密码
    port: '3307',                   //端口号
});

//创建一个connection
connection.connect(function (err) {
    if (err) {
        console.log('[query] - :' + err);
        return;
    }
    console.log('[connection connect]  succeed!');
});

//执行SQL语句
connection.query('SELECT * from ysys_topic', function (err, rows, fields) {
    if (err) {
        console.log('[query] - :' + err);
        return;
    }
    console.log('The solution is: ', rows[0]);
});
//关闭connection
connection.end(function (err) {
    if (err) {
        return;
    }
    console.log('[connection end] succeed!');
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
