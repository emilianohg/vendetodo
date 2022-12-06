<?php

namespace App\Console\Commands;

use App\Repositories\OrdenesRepository;
use Illuminate\Console\Command;

class RepartirOrdenesASurtidoresCommand extends Command
{
    protected $signature = 'ordenes:surtir';

    protected $description = 'Asigna un surtidor a una orden';

    public function handle()
    {
        /*
        $ordenesRepository = new OrdenesRepository();
        $ordenes = $ordenesRepository->getOrdenesPendientes();
        \Log::info($ordenes);
        */

        $str = '
            /**
             * @param int $orden_id
             * @param int $usuario_id
             * @param string $status
             * @param int $pago_id
             * @param string $fecha_creacion
             * @param int $direccion_envio_id
             * @param DetalleOrden[] $detalle
             * @param Pago $pago
             * @param Direccion $direccion
             * @param Usuario $cliente
             * @param int|null $surtidor_id
             * @param Usuario|null $surtidor
             */
        ';

        $starting_word = '@param';
        $ending_word = '$detalle';


/*
        function seekType($text, $starting_word, $ending_word)
        {
            foreach (preg_split("/\r\n|\n|\r/", $text) as $line) {
                echo $line . "<- \n";

                if (!str_contains($text, $starting_word) || !str_contains($text, $ending_word)) {
                    continue;
                }

                $subtring_start = strpos($text, $starting_word);
                $subtring_start += strlen($starting_word);
                $size = strpos($text, $ending_word, $subtring_start) - $subtring_start;
                return ;
            }

            return null;
        }

        $result = seekType($str, '@param', '$detalle');

        print_r($result);
*/
        return 0;
    }
}
