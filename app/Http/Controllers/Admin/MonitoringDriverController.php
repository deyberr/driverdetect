<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Device;
use App\Models\Driver;
use App\Models\incidence;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class MonitoringDriverController extends Controller
{
    public function index($id)
    {   
   
        $actual=Carbon::now();
        $año=$actual->year;
        $array_speed=array();
        $array_distance=array();

        $fecha=Carbon::now();
        $año=$fecha->year;

        $user=Driver::where("id_device","=",$id)->get();

        $id_user=$user[0]->id_user;

        $user=User::findOrFail($id_user);

        $device=Device::findOrFail($id);
        $actual = \Carbon\Carbon::now();
        $nacimiento =\Carbon\Carbon::parse($user->date_of_birth);
        $dif=$actual->diffInMonths($nacimiento);
        $años=$dif/12;
        $edad=(int)$años;


        $conductor=Driver::where("id_device","=",$id)->get()[0];
        $date_registro=\Carbon\Carbon::parse( $conductor->created_at);
        $dias=$actual->diffInDays($date_registro);
        $monitoreo=(int)$dias;

        for($i=1;$i<=12;$i++){
            $vel=$this->countFaltasSpeed($año,$i,$id);
            array_push($array_speed,$vel);
        }
        for($k=1;$k<=12;$k++){
            $dis=$this->countFaltasDistance($año,$k,$id);
            array_push($array_distance,$dis);
        }
        $count_inc = incidence::where('id_device','=',$id)->count();
        
    
        
        return view('admin.devices.monitoring.index',compact('count_inc','id','año','array_distance','array_speed','device','user','edad','monitoreo'));
    }

    public function countFaltasSpeed($year,$mes,$id_driver)
    {
        $total_v=incidence::where('id_driver','=',$id_driver)->whereYear('created_at','=',$year)
                        ->whereMonth('created_at','=',$mes)->where('type','=',0)->count();

        return $total_v;
    }
    public function countFaltasDistance($year,$mes,$id_driver)
    {
        $total_d=incidence::where('id_driver','=',$id_driver)->whereYear('created_at','=',$year)
                        ->whereMonth('created_at','=',$mes)->where('type','=',1)->count();

        return $total_d;
    }

    public  function  scriptArduino($id)
    {
        $device=Device::findOrFail($id);
        $name='script_id_user-'.$id.'.ino';

        if($device->url_script==''){

            $str = <<<STR
            /* wemos
 
            */
            #include <WiFiManager.h>
            #include <SoftwareSerial.h>
            #include <ESP8266WiFi.h>
            #include <PubSubClient.h>
            
            #include <Wire.h>
            #include <TinyGPSPlus.h>
            // Define Slave I2C Address
            #define SLAVE_ADDR 0
            #define ID 0
            #define IDUSER ${id}
            

            String generalTopic="driver";   
            ///proximidad

            char i,j = 0; 
            int rx_buf[9];
            const int HEADER=0x59;
            int check; //save check value
            ///proximidad

            ///Variables gps

            // se define el número de veces por segundo  en que la  comunicacion serial cambiara de estado
            static const uint32_t GPSBaud = 9600;
            // se define un arreglo de tipo double para almacenar lactitud, longitud,velocidad.
            String location[3]={"","",""};
            //instanciamos el gps
            TinyGPSPlus gps;
            //se definen los pipnes digitales  4rx amarillo y 3tx  verde para la cominicacion  serial  por software
            SoftwareSerial ss(D7,D8);
            // variables gps
            
            //wifi
            
            const char* ssid = "3113662698CRIS";
            const char* password = "4D9697500392";
            //wifi

            //mqtt
            const char mqtt_broker[] = "driver.cloudmqtt.com";
            const int mqtt_port =18925;
            const char mqtt_user[] = "wpzjocmx";
            const char mqtt_pass[] = "4iXOQYk0mgx6";
            const char mqtt_clientid[] = "kukurumbero2";  

            const char* mqtt_server = "driver.cloudmqtt.com";
            //mqtt




            WiFiClient espClient;
            PubSubClient client(espClient);
            unsigned long lastMsg = 0;
            #define MSG_BUFFER_SIZE  (50)
            char msg[MSG_BUFFER_SIZE];
            int value = 0;



            void gpsSetup(){
                ss.begin(GPSBaud);
                }
            void wifiSetup() {
            
            WiFiManager wifiManager;
            //wifiManager.resetSettings();
            std::vector<const char *> menu = {"wifi", "restart","exit"};
            wifiManager.setMenu(menu);
            // Descomentar para resetear configuración
            //wifiManager.resetSettings();

            // Cremos AP y portal cautivo
            wifiManager.autoConnect("DriverDetect");

            Serial.println("Ya estás conectado");
            }
            

            void reconnect() {
            // Loop until we're reconnected
            while (!client.connected()) {
                Serial.print("Attempting MQTT connection...");
                // Create a random client ID
                String clientId = "ESP8266Client-";
                clientId += String(random(0xffff), HEX);
                // Attempt to connect
                if (client.connect(clientId.c_str(), mqtt_user, mqtt_pass)) {
                Serial.println("connected");
            
            
                } else {
                Serial.print("failed, rc=");
                Serial.print(client.state());
                Serial.println(" try again in 5 seconds");
                // Wait 5 seconds before retrying
                delay(5000);
                }
            }
            }


            void mqttSetup() {
            
            
            client.setServer(mqtt_server, 18925);
            
            }

            void proximidadSetup() {
            Wire.begin();
            
            }


            void wifiloop(String topic ,String data) {

            if (!client.connected()) {
                reconnect();
            }
            client.loop();

            unsigned long now = millis();
            if (now - lastMsg > 2000) {
                lastMsg = now;
                ++value;
                Serial.print("Publish message: ");
            
                client.publish(topic.c_str(), data.c_str());
            }
            }
            void setup() {
            wifiSetup();
            mqttSetup();
            proximidadSetup();
            gpsSetup();
            
            // Setup serial monitor
            Serial.begin(9600); 
            }

            void loop() {
            delay(500);

            

            String *coordenadas=getGps();
                
            // se obtiene  y convierte la lectura de distancia 
            String  distancia=getDistancia();
            String  latitud  = coordenadas[0];
            String  longitud  =coordenadas[1]; 
            String  speedGps  =coordenadas[2];
            

            
            
            ///0=proximidad,1=latitud,2=longitud,3=speedGps
            Serial.println("{\"id\":"+String(IDUSER) +", \"lon\":"+longitud +" ,\"lat\":"+latitud +",\"speed\": "+speedGps +",\"proximity\":"+distancia+"}");
            if(latitud!="" &&longitud!="" &&speedGps!="" &&distancia!="" ){
                wifiloop(generalTopic,  "{\"id\":"+String(IDUSER) +", \"lon\":"+longitud +" ,\"lat\":"+latitud +",\"speed\": "+speedGps +",\"proximity\":"+distancia+"}");
            
                }else{
                
                    wifiloop(generalTopic,  "{\"id\":"+String(IDUSER) +", \"lon\":"+longitud +" ,\"lat\":"+latitud +",\"speed\": "+speedGps +",\"proximity\":"+distancia+"}");
            
                }
            }




            
            String getDistancia(){ 
            Wire.beginTransmission(0x10); // Begin a transmission to the I2C Slave device with the given address. 
            Wire.write(0x5A); // see product mannual table 11:Obtain Data Frame
            Wire.write(0x05); // 
            Wire.write(0x00); // 
            Wire.write(0x01); // 
            Wire.write(0x60); // 
            Wire.endTransmission();  // Send a END Sign
            delay(100);
            Wire.requestFrom((int)(0x10), 9); // request 9 bytes from slave device address
            //print the result via serial
            while ( Wire.available()) 
            {  
                //************
                if(Wire.read() == HEADER){
                rx_buf[i] = HEADER; // received first byte
                if (Wire.read() == HEADER) {
                    rx_buf[1] = HEADER;
                for (i = 2; i < 9; i++) {
                rx_buf[i] = Wire.read();
            }
                check = rx_buf[0] + rx_buf[1] + rx_buf[2] + rx_buf[3] + rx_buf[4] + rx_buf[5] + rx_buf[6] + rx_buf[7];
                //************
                if (rx_buf[8] == (check&0xff)){ //verify the received data as per protocol
                
                //##################################
            
            
                return String(rx_buf[3]*256+rx_buf[2]);
            
                }else{
                return "";}
                }
            }
            }
            
            }


            // se valida la disponibilidad del receptor
            void gpsValidation() {  
            ss.listen();
                if (gps.location.isValid()&&gps.speed.isValid()&& gps.speed.kmph()>0&&gps.speed.kmph()<=200)
                {
                location[0]=String(gps.location.lat());
                location[1]=String(gps.location.lng());    
                location[2]=String(gps.speed.kmph()); 
            
                }
                else 
                {
                location[0]="";
                location[1]="";    
                location[2]=""; 
                }
            
            }
            //funcion que mientras  haya  comunicacion con el receptor gps  verificara  el estado de la codificacion de la señal
            // y actualizara el arreglo location con los nuevos datos
            
            // función que retorna el estado del arreglo location
            String * getGps(void) {
            ss.listen(); 

            while (ss.available() > 0)
                if (gps.encode(ss.read()))
                gpsValidation();

            if (millis() > 5000 && gps.charsProcessed() < 10) {
                Serial.println(F("No GPS detected: check wiring."));
                //while (true)
                ;
            }else{
                Serial.println(F("gps ok."));
                
            }
            return  location;
            }
            STR;
          
            $url="/storage/scripts-arduino/".$name;
            $device->url_script=$url;
            if($device->update()){
                return Storage::download('scripts-arduino/'.$name,'script-'.$device->reference.'.ino');
            }else{
                return  back()->with('message','Ocurrio un error en la descarga');
            }
        }else{
            return Storage::download('scripts-arduino/'.$name,'script-'.$device->reference.'.ino');
        }


    }
}
