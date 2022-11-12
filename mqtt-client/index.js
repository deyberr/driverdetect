
const db= require('./conexion')
require('dotenv').config({path: '../.env'});
const mqtt = require('mqtt')

const clientId = `mqtt_${Math.random().toString(16).slice(3)}`
const connectUrl = `mqtt://${process.env.MQTT_HOST}:${process.env.MQTT_PORT}`

const client = mqtt.connect(connectUrl, {
  clientId,
  clean: true,
  connectTimeout: 4000,
  username:process.env.MQTT_USERNAME,
  password:process.env.MQTT_PASSWORD,
  reconnectPeriod: 1000,
})

const topic = process.env.MQTT_TOPIC
client.on('connect', () => {
  console.log('Connected')
  client.subscribe([topic], () => {
    console.log(`Subscribe to topic '${topic}'`)
  })

})
client.on('message', (topic, payload) => {

  const text= payload.toString();
  const encodeJS=JSON.parse(text);

  db.enviar_datos(encodeJS.id,encodeJS.lon,encodeJS.lat,encodeJS.speed,encodeJS.proximity);


  client.publish(topic+"/"+encodeJS.id,  specifiedData(encodeJS.id,encodeJS.lon,encodeJS.lat,encodeJS.speed,encodeJS.proximity), { qos: 0, retain: false }, (error) => {
      if (error) {
        console.error(error)
      }
    })
})

function test(){

  setInterval(() => {
    client.publish("/driverdetect/500",  specifiedData(500,Math.random()*40,Math.random()*40,Math.random()*40,Math.random()*40), { qos: 0, retain: false }, (error) => {
      if (error) {
        console.error(error)
      }
    })

    client.publish("/driverdetect",  specifiedData(500,Math.random()*40,Math.random()*40,Math.random()*40,Math.random()*40), { qos: 0, retain: false }, (error) => {
      if (error) {
        console.error(error)
      }
    })
  }, 2000);
}

test();

client.publish(topic, 'nodejs mqtt test', { qos: 0, retain: false }, (error) => {
    if (error) {
      console.error(error)
    }
})


function specifiedData(id=500,lon=1,lat=2,speed=3,proximity=20){
    let v= "{\"id\":"+id+",\"values\":{ \"lon\":"+lon+" ,\"lat\":"+lat+",\"speed\": "+speed+",\"proximity\":"+proximity+"}}"
     return v;
}
