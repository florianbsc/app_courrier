<?php



use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// importe les models
use App\Models\Courrier;
use App\Models\Centre;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\select;
use Illuminate\Support\Facades\Validator;
// verification pour verifier s'il y a des courrier agé de plus de 10 ans et les suprimer
$dateCreation = Courrier::all('date_courrier');
        // $birthTime = $birthTimes->date_courrier;

        $date = Carbon::parse('2023-12-01');

        $dateLimite = Carbon::now()->subYears(10);
        dd($date, $dateLimite);
        if ($date->lessThanOrEqualTo($dateLimite)) {
            // Courrier::where('date_courrier', '<=', $dateLimite)->delete();
                } 

        
