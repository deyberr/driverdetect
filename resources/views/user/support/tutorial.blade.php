<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @include('user.layouts.head-css')
  <title>Tutorial</title>
</head>
<body>
  <div class="p-1 h-100" id="tutorial">
  
  <div class="row cabecera p-2">
    <div class="col-12 col-md-8 m-auto">
        <h3 class="cl-white"><strong>Video Tutorial</strong></h3>
        <hr class="separator">
        <p class="cl-white descripcion">A continuacion se presenta un video enfocado en el manual de uso del aplcativo</p>
    </div>
  </div>
    
    <div  class="d-flex justify-content-center align-items-center" id="video_container"> 
        <video  class="" id="video" controls autoplay> 
            <source src="http://nettuts.s3.amazonaws.com/763_sammyJSIntro/trailer_test.mp4" type="video/mp4"> 
        
              
            <h4> No se logro reproducir el video </h4>
        </video> 
    </div>
    
  </div>
    
    
  </div>
  
</body>
</html>

  

<style>
  *{
    margin: 0px;
    padding: 0px;
  }
  body{
    width:100%;
    height:100vh;
    background: #474947;
    
  }
  .cabecera{
    height:15%;
    margin:0px;
  }
  .separator{
    background: white;
    
  }
  .cl-white{
    color:#E5EAE3;
  }
  .descripcion{
    font-size:15px;
  }
    #tutorial{
        width: 100%;
        height: 100%;
    }
    #video_container{
      height: 85%;
      width: 100%;
      
    }
    #video{
      -webkit-box-shadow: 0px 0px 11px 4px rgba(0,0,0,0.75);
-moz-box-shadow: 0px 0px 11px 4px rgba(0,0,0,0.75);
box-shadow: 0px 0px 11px 4px rgba(0,0,0,0.75);
      border:5px solid gray;
    }
    @media (max-width: 300px) {
        #video {
          height:150px;
          width: 200px;
        }
    }

    @media (min-width:300px ) and  (max-width:400px) {
        #video {
          height:250px;
          width: 290px;
        }
    }

    @media (min-width:400px ) and  (max-width:600px) {
        #video {
          height:250px;
          width: 390px;
        }
    }

    @media (min-width:600px ) and  (max-width:800px) {
        #video {
          height:250px;
          width: 590px;
        }
    }
    @media (min-width:800px ) and  (max-width:1000px) {
        #video {
          height:350px;
          width: 790px;
        }
    }
    @media (min-width:1001px) {
        #video {
          height:450px;
          width: 1000px;
        }
    }
   
</style>