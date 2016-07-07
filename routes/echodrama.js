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

/* Get listing. */
router.get('/topic/list', function (request, response, next) {
    var result = {code:1,message:'success',data: null};

    //创建一个connection
    connection.connect(function (err) {
        if (err) {
            console.log('[query] - :' + err);
            return;
        }
        console.log('[connection connect]  succeed!');
    });

    var sql = 'SELECT * from ysys_topic';
    connection.query(sql, function (err, rows, fields) {
        if (err){
            result.code = -1;
            result.message = err;
            response.send(result);
        } else{
            result.data = rows;
            response.send(result);
        }
    });



    //关闭connection
    connection.end(function (err) {
        if (err) {
            return;
        }
        console.log('[connection end] succeed!');
    });


});

module.exports = router;
