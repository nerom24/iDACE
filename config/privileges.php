<?php

    /*
        # Perfiles
        1 - Administrador
        2 - Editor
        3 - Registrado

        # Privilegios
        Perfiles	 	Nuevo	Editar	Eliminar	 Mostrar	Buscar 	Ordenar 
        ADMINISTRADOR	SI	    SI	    SI	         SI	        SI	    SI
        eDITOR	 	    SI	    SI	    NO	         SI	        SI	    SI 
        REGISTRADO	 	NO	    NO	    NO	         SI	        SI 	    SI


        # Definir privilegios como variables golbales

    */

    $GLOBALS['actividad']['main'] = [1, 2, 3];
    $GLOBALS['actividad']['new'] = [1, 2];
    $GLOBALS['actividad']['edit'] = [1, 2];
    $GLOBALS['actividad']['delete'] = [1];
    $GLOBALS['actividad']['show'] = [1, 2, 3];
    $GLOBALS['actividad']['filter'] = [1, 2, 3];
    $GLOBALS['actividad']['order'] = [1, 2, 3];