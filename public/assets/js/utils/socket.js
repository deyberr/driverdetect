

const clientMQTT = new Paho.MQTT.Client("driver.cloudmqtt.com", 38925, "client_" + parseInt(Math.random() * 100, 10));

clientMQTT.onConnectionLost = function onConnectionLost(responseObject) {
    if (responseObject.errorCode !== 0) {
        console.log("onConnectionLost:"+responseObject.errorMessage);
    }
};


const options = {
    useSSL: true,
    userName: "wpzjocmx",
    password: "4iXOQYk0mgx6",
    onFailure: function onFail(e){
        console.log(e);
    }

}










