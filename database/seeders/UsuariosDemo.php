<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuariosDemo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::create([
        //     'nombres' => 'Marcos Admin',
        //     'apellidos' => 'Peres',
        //     'rol' => 1,
        //     'estado' => 1,
        //     'email' => 'nearlino20@gmail.com',
        //     'password' => Hash::make('demo'),
        // ])->assignRole('Administrador');

        // User::create([
        //     'nombres' => 'Ariel Admin',
        //     'apellidos' => 'Luque Cusacani',
        //     'rol' => 1,
        //     'estado' => 1,
        //     'email' => 'jhonar.theking@gmail.com',
        //     'password' => Hash::make('demo'),
        // ])->assignRole('Administrador');

        User::create(['nombres' => 'ARNOL ALONSO', 'apellidos'=>'AGUILAR LIMA','rol'=>2,'estado'=>1,'email'=>'al_arnol@inventario.com', 'password'=>Hash::make('al_arnol'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'MIRIAN GLADYS', 'apellidos'=>'ALVAREZ TORRES','rol'=>2,'estado'=>1,'email'=>'at_mirian@inventario.com', 'password'=>Hash::make('at_mirian'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'JAVIER EMERSON', 'apellidos'=>'APAZA CHOQUEHUANCA','rol'=>2,'estado'=>1,'email'=>'ac_javier@inventario.com', 'password'=>Hash::make('ac_javier'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'DAYMIR ', 'apellidos'=>'APAZA FLORES','rol'=>2,'estado'=>1,'email'=>'af_daymir@inventario.com', 'password'=>Hash::make('af_daymir'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'GUISELA ', 'apellidos'=>'ARI COSI','rol'=>2,'estado'=>1,'email'=>'ac_guisela@inventario.com', 'password'=>Hash::make('ac_guisela'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'ROBERT MAX', 'apellidos'=>'QUISPE QUISPE','rol'=>2,'estado'=>1,'email'=>'qq_robert@inventario.com', 'password'=>Hash::make('qq_robert'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'DAVY THOMSON', 'apellidos'=>'CALLERI CAXI','rol'=>2,'estado'=>1,'email'=>'cc_davy@inventario.com', 'password'=>Hash::make('cc_davy'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'GABRIELA YAMELIT', 'apellidos'=>'BALCONA CCAMA','rol'=>2,'estado'=>1,'email'=>'bc_gabriela@inventario.com', 'password'=>Hash::make('bc_gabriela'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'ESTHER ', 'apellidos'=>'BARREDA ARPI','rol'=>2,'estado'=>1,'email'=>'ba_esther@inventario.com', 'password'=>Hash::make('ba_esther'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'RENATO JORDAN', 'apellidos'=>'BENTACUR MAMAMNI','rol'=>2,'estado'=>1,'email'=>'bm_renato@inventario.com', 'password'=>Hash::make('bm_renato'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'MYUMI AMERICA', 'apellidos'=>'BORDA VARGAS','rol'=>2,'estado'=>1,'email'=>'bv_myumi@inventario.com', 'password'=>Hash::make('bv_myumi'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'YOVANA YORKA', 'apellidos'=>'CACERES CHOQUE','rol'=>2,'estado'=>1,'email'=>'cc_yovana@inventario.com', 'password'=>Hash::make('cc_yovana'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'MARILIN ', 'apellidos'=>'MENDOZA QUISPE','rol'=>2,'estado'=>1,'email'=>'mq_marilin@inventario.com', 'password'=>Hash::make('mq_marilin'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'CARLOS ALBERTO', 'apellidos'=>'CHOQUE MAMANI','rol'=>2,'estado'=>1,'email'=>'cm_carlos@inventario.com', 'password'=>Hash::make('cm_carlos'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'JULIETA CATERINE', 'apellidos'=>'FERNANDEZ BLAS','rol'=>2,'estado'=>1,'email'=>'fb_julieta@inventario.com', 'password'=>Hash::make('fb_julieta'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'CINTYA OLENKA', 'apellidos'=>'CHOQUE MOLLOCONDO','rol'=>2,'estado'=>1,'email'=>'cm_cintya@inventario.com', 'password'=>Hash::make('cm_cintya'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'SUSSY ', 'apellidos'=>'CHOQUEMALLCO TICONA','rol'=>2,'estado'=>1,'email'=>'ct_sussy@inventario.com', 'password'=>Hash::make('ct_sussy'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'ELIZABETH FLORA', 'apellidos'=>'CONDORI LLANOS','rol'=>2,'estado'=>1,'email'=>'cl_elizabeth@inventario.com', 'password'=>Hash::make('cl_elizabeth'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'HERDER WILDO', 'apellidos'=>'COSI QUISPE','rol'=>2,'estado'=>1,'email'=>'cq_herder@inventario.com', 'password'=>Hash::make('cq_herder'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'ROCIO MARITZA', 'apellidos'=>'MAMANI LIZAMA','rol'=>2,'estado'=>1,'email'=>'ml_rocio@inventario.com', 'password'=>Hash::make('ml_rocio'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'FERNANDO ', 'apellidos'=>'DUEÑAS RUELAS','rol'=>2,'estado'=>1,'email'=>'dr_fernando@inventario.com', 'password'=>Hash::make('dr_fernando'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'LEYDI PATRICIA', 'apellidos'=>'GALLEGOS GORDILLO','rol'=>2,'estado'=>1,'email'=>'gg_leydi@inventario.com', 'password'=>Hash::make('gg_leydi'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'LOURDES ', 'apellidos'=>'GALLEGOS RUELAS','rol'=>2,'estado'=>1,'email'=>'gr_lourdes@inventario.com', 'password'=>Hash::make('gr_lourdes'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'LENIN ', 'apellidos'=>'GONZALES HERRERA','rol'=>2,'estado'=>1,'email'=>'gh_lenin@inventario.com', 'password'=>Hash::make('gh_lenin'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'YELKA NAIRIBI', 'apellidos'=>'GUTIERREZ EDUARDO','rol'=>2,'estado'=>1,'email'=>'ge_yelka@inventario.com', 'password'=>Hash::make('ge_yelka'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'GISELA ', 'apellidos'=>'HUACANI MAMANI','rol'=>2,'estado'=>1,'email'=>'hm_gisela@inventario.com', 'password'=>Hash::make('hm_gisela'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'ANALY ', 'apellidos'=>'RODRIGUEZ GOMEZ','rol'=>2,'estado'=>1,'email'=>'rg_analy@inventario.com', 'password'=>Hash::make('rg_analy'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'GROBER ', 'apellidos'=>'RUELAS VELARDE','rol'=>2,'estado'=>1,'email'=>'rv_grober@inventario.com', 'password'=>Hash::make('rv_grober'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'BERTHA MAKSELY', 'apellidos'=>'ILLACUTIPA CALCINA','rol'=>2,'estado'=>1,'email'=>'ic_bertha@inventario.com', 'password'=>Hash::make('ic_bertha'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'EDITH ', 'apellidos'=>'ISIDRO CHAGUA','rol'=>2,'estado'=>1,'email'=>'ic_edith@inventario.com', 'password'=>Hash::make('ic_edith'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'TANIA MISYUMI', 'apellidos'=>'LIMA LIMA','rol'=>2,'estado'=>1,'email'=>'ll_tania@inventario.com', 'password'=>Hash::make('ll_tania'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'SHAROM EMPERATRIZ', 'apellidos'=>'LUQUE LIRA','rol'=>2,'estado'=>1,'email'=>'ll_sharom@inventario.com', 'password'=>Hash::make('ll_sharom'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'RAFHAEL JOEL', 'apellidos'=>'VARGAS RAMOS','rol'=>2,'estado'=>1,'email'=>'vr_rafhael@inventario.com', 'password'=>Hash::make('vr_rafhael'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'MIGUEL ALEXANDER', 'apellidos'=>'MEDINA SANTANDER','rol'=>2,'estado'=>1,'email'=>'ms_miguel@inventario.com', 'password'=>Hash::make('ms_miguel'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'YULIBETH CARMEN', 'apellidos'=>'TICONA FLORES','rol'=>2,'estado'=>1,'email'=>'tf_yulibeth@inventario.com', 'password'=>Hash::make('tf_yulibeth'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'ALBERT ', 'apellidos'=>'RAMOS QUISPE','rol'=>2,'estado'=>1,'email'=>'rq_albert@inventario.com', 'password'=>Hash::make('rq_albert'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'IBETH GUADALUPE', 'apellidos'=>'HUANCAPAZA CANAZA','rol'=>2,'estado'=>1,'email'=>'hc_ibeth@inventario.com', 'password'=>Hash::make('hc_ibeth'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'JHON ARIEL', 'apellidos'=>'LUQUE CUSACANI','rol'=>2,'estado'=>1,'email'=>'lc_jhon@inventario.com', 'password'=>Hash::make('lc_jhon'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'DENIS LINO', 'apellidos'=>'PUMA TICONA','rol'=>2,'estado'=>1,'email'=>'pt_denis@inventario.com', 'password'=>Hash::make('pt_denis'),  ])->assignRole('Inventario');







    }
}
