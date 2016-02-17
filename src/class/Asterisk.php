<?php
/**
 * Asterisk File
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

 /**
  * Asterisk Class
  *
  * @category Core
  * @package  YujuFramework
  * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
  * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
  * @link     https://github.com/yuju-framework/yuju
  * @since    version 1.0
  */
class Asterisk
{

    protected $socket;
    protected $error;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->socket = false;
    }

    /**
     * Login Asterisk
     *
     * @param string $host IP o host de Asterisk
     * @param string $port puerto de conexión
     * @param string $user nombre de usuario
     * @param string $pass contraseña
     *
     * @return boolean
     */
    public function login($host, $port, $user, $pass)
    {
        // No se indica ni el codigo de error ni mensaje de erro ni timeout
        $this->socket = @fsockopen($host, $port);
        if (!$this->socket) {
            $this->error = 'error conectar';
            return false;
        }
        $buffer = fgets($this->socket);
        $return = $this->send(
            "Action: Login\r\nUserName: ".
            $user."\r\nSecret: ".$pass.
            "\r\nEvents: off"
        );
        if ($return[0]!='Response: Success') {
            $this->error = 'Error login -> '.$return[1];
            return false;
        }
        return true;
    }

    /**
     * Realizar una llamada
     *
     * @param string $extension    extensión que realiza la llamada
     * @param string $telefono     número de teléfono al que se desea llamar
     * @param string $telefonofrom número de teléfono desde el que se llama
     *
     * @return boolean
     */
    public function call($extension, $telefono, $telefonofrom = '')
    {
        if ($telefonofrom!='') {
            $telefonofrom = "\r\nCallerID: ".$telefonofrom;
        }
        $return = $this->send(
            "Action: Originate\r\nChannel: SIP/".
            $extension."\r\nExten: 0".$telefono.
            "\r\nPriority: 1\r\nContext: operadors".$telefonofrom
        );
        if ($return[0]!='Response: Success') {
            $this->error = 'Error call -> '.$return[1];
            return false;
        }
        return true;
    }

    /**
     * Realizar una llamada y suena una locución predefinida
     *
     * @param string $data         locución que realiza la llamada
     * @param string $telefono     número de teléfono al que se desea llamar
     * @param string $telefonofrom número de teléfono desde el que se llama
     *
     * @return boolean
     */
    public function callPlayback($data, $telefono, $telefonofrom = '')
    {
        if ($telefonofrom!='') {
            $telefonofrom = "\r\nCallerID: ".$telefonofrom;
        }

        $return = $this->send(
            "Action: Originate\r\nChannel: SIP/idg/".
            $telefono."\r\nData: ".$data.
            "\r\nApplication: Playback".$telefonofrom
        );
        if ($return[0]!='Response: Success') {
            $this->error = 'Error call -> '.$return[1];
            return false;
        }
        return true;
    }

    /**
     * XXX
     *
     * @param string $slot      slot
     * @param string $extension extension
     * @param string $timeout   timeout
     *
     * @return boolean
     */
    public function callParkedCalls($slot, $extension, $timeout = '30000')
    {
        $return = $this->send(
            "Action: Originate\r\nChannel: SIP/".
            $extension."\r\nExten: ".$slot.
            "\r\nContext: parkedcalls\r\nPriority: 1\r\nTimeout: ".
            $timeout
        );
        if ($return[0]!='Response: Success') {
            $this->error = 'Error call -> '.$return[1];
            return false;
        }
        return true;
    }

    /**
     * Añadir una extensión a una cola
     *
     * @param string $cola      nombre de la cola
     * @param string $extension extensión
     *
     * @return boolean
     */
    public function addQueue($cola, $extension)
    {
        $return = $this->send(
            "Action: QueueAdd\r\nQueue: ".
            $cola."\r\nInterface: SIP/".$extension
        );
        if ($return[0]!='Response: Success') {
            $this->error = 'Error addQueue -> '.$return[1];
            return false;
        }
        return true;
    }

    /**
     * Eliminar extensión de una cola
     *
     * @param string $cola      nombre de la cola
     * @param string $extension extensión
     *
     * @return boolean
     */
    public function removeQueue($cola, $extension)
    {
        $return = $this->send(
            "Action: QueueRemove\r\nQueue: ".
            $cola."\r\nInterface: SIP/".$extension
        );
        if ($return[0]!='Response: Success') {
            $this->error = 'Error removeQueue -> '.$return[1];
            return false;
        }
        return true;
    }

    /**
     * Park call
     *
     * @param string $slot      slot
     * @param string $extension extension
     * @param string $timeout   timeout
     *
     * @return boolean
     */
    public function park($slot, $extension, $timeout = '3600000')
    {
        $channel = $this->getChannelFromExtension($extension);
        if ($channel !==false) {
            $from_channel = $this->getCallerChannelFromChannel('SIP/'.$channel);
            $return = $this->send(
                "Action: Park\r\nChannel: ".
                $from_channel."\r\nParkinglot: ".
                $slot."\r\nChannel2: SIP/".$channel."\r\nTimeout: ".$timeout
            );
            if ($return[0]!='Response: Success') {
                $this->error = 'Error Park -> '.$return[1];
                return false;
            }
        }
        return true;
    }

    /**
     * Devuelve el número de teléfono del número llamado por una extensión dada
     *
     * @param string $extension extensión
     *
     * @return string|boolean
     */
    public function getCallerFromExtension($extension)
    {
        $telefono['to'] ='';
        $telefono['from'] = '';
        $channels = $this->command('core show channels');
        foreach ($channels as $linia) {
            preg_match('/SIP\/'.$extension.'-(?P<canal>\w+)\s+(?P<telefono>\d+)@\w+/', $linia, $matches);
            if (isset($matches['canal']) && isset($matches['telefono'])) {
                $telefono['to'] = $matches['telefono'];
                $llamada = $this->command(
                    'core show channel SIP/'.
                    $extension.'-'.$matches['canal']
                );
                $linea_entera = explode(': ', $llamada[9]);
                $telefono['from'] = $linea_entera[1];
                return $telefono;
            }

        }
        return false;
    }

    /**
     * XXX
     *
     * @param string $extension extension
     *
     * @return string|boolean
     */
    public function getChannelFromExtension($extension)
    {
        $channels = $this->command('core show channels');
        foreach ($channels as $linia) {
            preg_match('/SIP\/'.$extension.'-(?P<canal>\w+)\s+/', $linia, $matches);
            if (isset($matches['canal'])) {
                return $extension.'-'.$matches['canal'];
            }

        }
        return false;
    }

    /**
     * XXX
     *
     * @param string $channel name channel
     *
     * @return string|boolean
     */
    public function getCallerChannelFromChannel($channel)
    {
        $lines = $this->command('core show channel '.$channel);
        foreach ($lines as $linia) {
            preg_match('/Indirect Bridge: (?P<canal>\S+)/', $linia, $matches);
            if (isset($matches['canal'])) {
                return $matches['canal'];
            }

        }
        return false;
    }

    /**
     * Get statistics
     *
     * @return array
     */
    public function getStatistics()
    {
        $llamadas_espera = 0;
        $total_tiempo = 0;
        $num_colas =0;
        $lines = $this->command('queue show');
        foreach ($lines as $line) {
            if (preg_match("/talktime/i", $line)) {
                $pieces = explode(" ", $line);
                $llamadas_espera+= $pieces[2];
                $total_tiempo += trim($pieces[9], "(s");
                $num_colas++;
            }
        }
        if ($num_colas == 0) {
            $media=0;
        } else {
            $media=$total_tiempo / $num_colas;
        }

        $minutos=str_pad(floor($media / 60), 2, '0', STR_PAD_LEFT);
        $segundos=str_pad($media % 60, 2, '0', STR_PAD_LEFT);

        $estadisticas['llamada_espera']=$llamadas_espera;
        $estadisticas['medio_espera']=$minutos.':'.$segundos;
        return $estadisticas;
    }

    /**
     * XXX
     *
     * @param unknown $extension extension
     * @param unknown $pausar    pause
     *
     * @return boolean
     */
    public function queuePause($extension, $pausar)
    {
        $return = $this->send(
            "Action: QueuePause\r\nInterface: SIP/"
            .$extension."\r\nPaused: ".$pausar
        );
        if ($return[0]!='Response: Success') {
            $this->error = 'Error removeQueue -> '.$return[1];
            return false;
        }
        return true;
    }

    /**
     * Envía un comando vía AMI
     *
     * @param string $comando comando
     *
     * @return array|boolean
     */
    public function command($comando)
    {
        $return = $this->send("Action: Command\r\nCommand: ".$comando);
        return $return;
        if ($return[0]!='Response: Success') {
            $this->error = 'Error removeQueue -> '.$return[1];
            return false;
        }
        return true;
    }

    /**
     * Retorna el estado de una extensión
     * Posibles valores:
     * - "1": Disponible por que esta esperando llamada, le está sonando
     *     el teléfono o bien está en una llamada
     * - "-1": No disponible porque está marcado como no Disponible
     *     (en asterisk pausado)
     * - "0": No conectado
     *
     * @param string $extension extensión
     *
     * @return number
     */
    public function estadoExtension($extension)
    {
        $result = $this->command('queue show');
        foreach ($result as $line) {
            if (strpos($line, 'SIP/'.$extension)!== false) {
                // Si está disponible, recibiendo una nueva llamada o
                // bien en una llamada
                // Si está en pausa indicamos No disponible
                if (strpos($line, '(paused)')!== false) {
                    return -1;
                } elseif (strpos($line, '(Not in use)')!== false
                    || strpos($line, '(Ringing)')!== false
                    || strpos($line, '(In use)')!== false
                ) {
                    return 1;
                }
            }
        }
        return 0;
    }

    /**
     * Realiza un logout de Asterisk
     *
     * @return void
     */
    public function logout()
    {
        $this->send("Action: Logoff");
        fclose($this->socket);
    }

    /**
     * Retorna el último mensaje de error generado
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Envía información al Asterisk y retorna la respuesta
     *
     * @param string $message mensaje
     *
     * @return boolean|string
     */
    public function send($message)
    {
        $return = array();
        if (!$this->socket) {
            return false;
        }
        if (!fwrite($this->socket, $message."\r\n\r\n")) {
            return false;
        }

        while (($buffer = fgets($this->socket))!==false) {
            if ($buffer=="\r\n") {
                break;
            }
            if (substr($buffer, -2) == "\r\n") {
                $return[] = substr($buffer, 0, strlen($buffer)-2);
            } else {
                $return[] = substr($buffer, 0, strlen($buffer)-1);
            }
        }

        return $return;
    }
}
