<?php



?>


<div class="row">

   <div class="col-sm-12">
      <div id="contact-form" class="clearfix">

         <p>Hola, dejanos tu mensaje y nos pondremos en contacto..</p>
         <form role="form" class="form" id="form">
            <div>
               <label class="sr-only" for="nombre">Nombre </label><span class="required">*</span>
               <input type="text" id="nombre" name="nombre" value="" placeholder="Nombre" required="required" autofocus="autofocus" />
            </div>
            <div>
               <label class="sr-only" for="apellido">Apellidos </label><span class="required">*</span>
               <input type="text" id="apellido" name="apellido" value="" placeholder="Apellidos" required="required" />
            </div>
            <div>
               <label class="sr-only" for="telefono">Número de teléfono </label>
               <input type="text" id="telefono" name="telefono" value="" placeholder="Número de teléfono"/>
            </div>
            <div>
               <label class="sr-only" for="email">Correo electrónico </label><span class="required">*</span>
               <input type="email" id="email" name="email" value="" placeholder="Correo electrónico" required="required" />
            </div>
            <style>
            /* Customize the label (the container) */
            .container {
              display: block;
              position: relative;
              padding-left: 35px;
              margin-bottom: 12px;
              cursor: pointer;
              font-size: 22px;
              -webkit-user-select: none;
              -moz-user-select: none;
              -ms-user-select: none;
              user-select: none;
            }

            /* Hide the browser's default checkbox */
            .container input {
              position: absolute;
              opacity: 0;
              cursor: pointer;
              height: 0;
              width: 0;
            }

            /* Create a custom checkbox */
            .checkmark {
              position: absolute;
              top: 0;
              left: 0;
              height: 25px;
              width: 25px;
              background-color: #eee;
            }

            /* On mouse-over, add a grey background color */
            .container:hover input ~ .checkmark {
              background-color: #ccc;
            }

            /* When the checkbox is checked, add a blue background */
            .container input:checked ~ .checkmark {
              background-color: #2196F3;
            }

            /* Create the checkmark/indicator (hidden when not checked) */
            .checkmark:after {
              content: "";
              position: absolute;
              display: none;
            }

            /* Show the checkmark when checked */
            .container input:checked ~ .checkmark:after {
              display: block;
            }

            /* Style the checkmark/indicator */
            .container .checkmark:after {
              left: 9px;
              top: 5px;
              width: 5px;
              height: 10px;
              border: solid white;
              border-width: 0 3px 3px 0;
              -webkit-transform: rotate(45deg);
              -ms-transform: rotate(45deg);
              transform: rotate(45deg);
            }
          </style>
             <div class="checkbox">
               <label>
               <input type="checkbox" value="">
               <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
               Option one is this and that — be sure to include why it's great
               </label>
            </div>

            <div id="radio-box-model">
               <input type="checkbox" id="aceptacondiciones" name="aceptacondiciones" required="required" /> leyenda1
            </div>
            <div>
               <input type="checkbox" id="opcion2" name="aceptacondiciones" required="required" /> leyenda2
            </div>
            <div>
               <input type="checkbox" id="opcion3" name="aceptacondiciones" required="required" /> leyenda3
            </div>


         <input type="hidden" name="accion" id="accion" value="insertarFormularios">

         <input type="button" value="Enviar"></input>
         <!-- <span id="loading"></span> -->
         <!-- <input type="submit" value="Holla!" id="submit-button" /> -->
         <p id="req-field-desc"><span class="required">*</span> Campos requeridos</p>
         </form>
      </div>
   </div>
</div>
