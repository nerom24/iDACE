<?php

    /*
        Creamos una clase para cada tabla
        las propiedades públicas y una propiedad para cada columna

        No respetará la propiedad de encapsulamiento.
    */

    class Actividad {

        public $id; 
        public $num_actividad;
        public $curso;
        public $titulo;
        public $descripcion;
        public $jornadas;
        public $fecha_inicio;
        public $fecha_fin;
        public $hora_inicio;
        public $hora_fin;
        public $dia_completo;
        public $horas_lectivas;
        public $eval;
        public $cursos;
        public $observaciones_cursos_horas;
        public $especialidad;
        public $tramo_horario;
        public $num_alumnos;
        public $lugar_celebracion;
        public $colaboracion_coordinador;
        public $colaboracion_departamentos;
        public $profesores_participantes;
        public $que_hacen_afectados;
        public $observaciones;
        public $adjuntos;
        public $categorias;
        public $estado;
        public $departamento_id;
        public $coordinador_id;
        public $email;
        public $nombre;



        public function __construct(
            $id                             = null,
            $num_actividad                  = null,
            $curso                          = null,
            $titulo                         = null,
            $descripcion                    = null,
            $jornadas                       = 1,
            $fecha_inicio                   = null,
            $fecha_fin                      = null,
            $hora_inicio                    = null,
            $hora_fin                       = null,
            $dia_completo                   = false,
            $horas_lectivas                 = null,
            $eval                           = null,
            $cursos                         = [],
            $observaciones_cursos_horas     = null,
            $especialidad                   = null,
            $tramo_horario                  = [],
            $num_alumnos                    = null,
            $lugar_celebracion              = null,
            $colaboracion_coordinador       = null,
            $colaboracion_departamentos     = null,
            $profesores_participantes       = null,
            $que_hacen_afectados            = null,
            $observaciones                  = null,
            $adjuntos                       = null,
            $categorias                     = null,
            $estado                         = null,
            $departamento_id                = null,
            $coordinador_id                 = null,
            $email                          = null,
            $nombre                         = null
        ) {
            $this->id                             = $id;
            $this->num_actividad                  = $num_actividad;
            $this->curso                          = $curso;
            $this->titulo                         = $titulo;
            $this->descripcion                    = $descripcion;
            $this->jornadas                       = $jornadas;
            $this->fecha_inicio                   = $fecha_inicio;
            $this->fecha_fin                      = $fecha_fin;
            $this->hora_inicio                    = $hora_inicio;
            $this->hora_fin                       = $hora_fin;
            $this->dia_completo                   = $dia_completo;
            $this->horas_lectivas                 = $horas_lectivas;
            $this->eval                           = $eval;
            $this->cursos                         = $cursos;
            $this->observaciones_cursos_horas     = $observaciones_cursos_horas;
            $this->especialidad                   = $especialidad;
            $this->tramo_horario                  = $tramo_horario;
            $this->num_alumnos                    = $num_alumnos;
            $this->lugar_celebracion              = $lugar_celebracion;
            $this->colaboracion_coordinador       = $colaboracion_coordinador;
            $this->colaboracion_departamentos     = $colaboracion_departamentos;
            $this->profesores_participantes       = $profesores_participantes;
            $this->que_hacen_afectados            = $que_hacen_afectados;
            $this->observaciones                  = $observaciones;
            $this->adjuntos                       = $adjuntos;
            $this->categorias                     = $categorias;
            $this->estado                         = $estado;
            $this->departamento_id                = $departamento_id;
            $this->coordinador_id                 = $coordinador_id;
            $this->email                          = $email;
            $this->nombre                         = $nombre;
        }


        
    }

?>