<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ParticipantesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('participantes')->delete();
        
        \DB::table('participantes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nombres_apellidos' => 'Alain Cesar Cervantes Parejo',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'nombres_apellidos' => 'Alberto Rueda Peña',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'nombres_apellidos' => 'Alejandro Alzate Tovar',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'nombres_apellidos' => 'Alejandro Granada Gonzalez',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'nombres_apellidos' => 'Alvaro Ruben Cabrera Morera',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'nombres_apellidos' => 'Andres David Rios Ramos ',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'nombres_apellidos' => 'Aura Cristina Bolaños Romero',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'nombres_apellidos' => 'Brayan Stiven Riascos Arroyo',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'nombres_apellidos' => 'Breiner Andrés Rojas Angulo',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'nombres_apellidos' => 'Carlos Eduardo Tellez Villa',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'nombres_apellidos' => 'Carlos Eduardo Usma Rivera',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'nombres_apellidos' => 'Christian Adolfo Olejua Manrique',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'nombres_apellidos' => 'Christian David Cruz Oviedo',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'nombres_apellidos' => 'Christian David Valencia Grisales',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'nombres_apellidos' => 'Daniel Felipe Chaparro Villada',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'nombres_apellidos' => 'Daniel Santiago Herrera Martinez',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'nombres_apellidos' => 'Danny Alexander Cevallos Vanegas',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'nombres_apellidos' => 'David Santiago Suárez Barragán',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'nombres_apellidos' => 'Diego Alexander Moreno Granados',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'nombres_apellidos' => 'Edison Yesid Hincapie Gómez',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'nombres_apellidos' => 'Emersson Mendoza Laiton',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'nombres_apellidos' => 'Ernesto Betancourt Ramirez',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'nombres_apellidos' => 'Fabiany Madrigal Salazar',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'nombres_apellidos' => 'Fredy Junior Mendoza Padilla',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'nombres_apellidos' => 'Gabriel Ricardo Suarez Vargas',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'nombres_apellidos' => 'Geber Froilan Orta Tovar',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'nombres_apellidos' => 'Geraldine Alexandra Merchán Cárdenas',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'nombres_apellidos' => 'Ivan Rene Caro Cataño',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'nombres_apellidos' => 'Jaime Andres Morales Ortiz',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'nombres_apellidos' => 'Jaime Enrique Gaviria Bonilla',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'id' => 31,
                'nombres_apellidos' => 'Jefferson David Izquierdo Escobar',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'id' => 32,
                'nombres_apellidos' => 'Jhonier Steven Alzate Echeverry',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            32 => 
            array (
                'id' => 33,
                'nombres_apellidos' => 'John Alejandro Galeano Espinosa',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            33 => 
            array (
                'id' => 34,
                'nombres_apellidos' => 'Jorge Armando Dotor Delgadillo',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            34 => 
            array (
                'id' => 35,
                'nombres_apellidos' => 'Jorge Arturo Herrera Jiménez',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            35 => 
            array (
                'id' => 36,
                'nombres_apellidos' => 'Jose Limberto Arrieta Narvaez',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            36 => 
            array (
                'id' => 37,
                'nombres_apellidos' => 'Juan Camilo Amaya Hernandez',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            37 => 
            array (
                'id' => 38,
                'nombres_apellidos' => 'Juan Camilo Guerrero Calderón',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            38 => 
            array (
                'id' => 39,
                'nombres_apellidos' => 'Juan Camilo Guerrero Melchor',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            39 => 
            array (
                'id' => 40,
                'nombres_apellidos' => 'Juan David Britto Argote',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            40 => 
            array (
                'id' => 41,
                'nombres_apellidos' => 'Juan Diego Valencia Arbelaez',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            41 => 
            array (
                'id' => 42,
                'nombres_apellidos' => 'Juliet Shirley López Revelo',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            42 => 
            array (
                'id' => 43,
                'nombres_apellidos' => 'Julieth Marcela Cruz Oviedo',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            43 => 
            array (
                'id' => 44,
                'nombres_apellidos' => 'Kevin Madrid',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            44 => 
            array (
                'id' => 45,
                'nombres_apellidos' => 'Luis Alberto Hernandez Moreno',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            45 => 
            array (
                'id' => 46,
                'nombres_apellidos' => 'Luis Eduardo Sánchez Pulido',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            46 => 
            array (
                'id' => 47,
                'nombres_apellidos' => 'María del Pilar Reyes Angarita',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            47 => 
            array (
                'id' => 48,
                'nombres_apellidos' => 'Michael Stiven Perez Quintero',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            48 => 
            array (
                'id' => 49,
                'nombres_apellidos' => 'Norman Andres Agudelo Mejia',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            49 => 
            array (
                'id' => 50,
                'nombres_apellidos' => 'Ruth Liliana Suarez Suarez',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            50 => 
            array (
                'id' => 51,
                'nombres_apellidos' => 'Sandra Lorena Rocha Barragán',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            51 => 
            array (
                'id' => 52,
                'nombres_apellidos' => 'Santiago Bermúdez Cáceres',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            52 => 
            array (
                'id' => 53,
                'nombres_apellidos' => 'Sebastian Gil Benavidez',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            53 => 
            array (
                'id' => 54,
                'nombres_apellidos' => 'Shaden Daniela Acevedo Quintero',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            54 => 
            array (
                'id' => 55,
                'nombres_apellidos' => 'Viviana Katherine Marines Bolaños',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            55 => 
            array (
                'id' => 56,
                'nombres_apellidos' => 'William Andres Leyton Fandiño',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            56 => 
            array (
                'id' => 57,
                'nombres_apellidos' => 'Karen Stephanie Cortés',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            57 => 
            array (
                'id' => 58,
                'nombres_apellidos' => 'Johan Balbuena',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}