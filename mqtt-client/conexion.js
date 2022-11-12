require('dotenv').config({path: '../.env'});
const { Pool } = require("pg")
// Coloca aquí tus credenciales
const pool = new Pool({
  user: process.env.DB_USERNAME,
  host: process.env.DB_HOST,
  database: process.env.DB_DATABASE,
  password: process.env.DB_PASSWORD,
  port:process.env.DB_PORT,
});


 const sendData= async (id,lon,lat,speed,proximity)   =>
{
//  console.log(id,lon,lat,speed,proximity)
// como parametro se solicita el id del dispositivo, luego realiza una consulta para obtener el id  del vinculo existente,
 try {
   // la consulta sql devuelve el id del vunculo   al que pertenece el dispositivo

  //console.log (rest.rows[0].id);


  // se llama a la función insertar registro y se añaden los parametros




    const rest=await pool.query("select id from drivers where id_device=$1",[id]);

   /// console.log ("id de driver: "+ rest2.rows[0].id);

    ///  console.log("conexion:"+rest.rows[0].id);
    if(rest.rows[0]){
        ///  console.log("conexion:"+rest.rows[0].id);
          insertarRegistro(id,rest.rows[0].id,lon,lat,speed,proximity);
        }


 } catch(e){
   console.log(e);
 }
};
const insertarRegistro = async (id_device,id_driver,lon,lat,speed,proximity)   =>
{
 try {
// se define el sql a utilizar

  // se cargan los valores a insertarRegistr

    // se ejecuta el sqlit
    const rest=await pool.query("insert into variables (id_device,id_driver,lon,lat,speed,proximity, created_at, updated_at) values($1,$2,$3,$4,$5,$6,$7,$8)", [id_device,id_driver ,lon,lat,speed,proximity, 'now()','now()']);


  } catch(e){
   console.log(e);
 }
};

module.exports = pool;
module.exports = {"enviar_datos": sendData};
