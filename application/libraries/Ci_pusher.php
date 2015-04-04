<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pusher for CodeIgniter
 *
 * Simple library that wraps the Pusher PHP library (https://github.com/pusher/pusher-http-php)
 * and give access to the Pusher methods using regular CodeIgniter syntax.
 *
 * This library requires that Pusher PHP Library is installed with composer, and that CodeIgniter
 * config is set to autoload the vendor folder. More information in the CodeIgniter user guide at
 * http://www.codeigniter.com/userguide3/general/autoloader.html?highlight=composer
 *
 * @package     CodeIgniter
 * @category    Libraries
 * @author      Mattias Hedman
 * @license     MIT
 * @link        https://github.com/darkwhispering/pusher-for-codeigniter
 * @version     1.0.0
 */

Class Ci_pusher
{

    public function __construct()
    {
        // Load config
        $this->load->config('pusher');

        // Get config variables
        $app_id     = $this->config->item('pusher_app_id');
        $app_key    = $this->config->item('pusher_app_key');
        $app_secret = $this->config->item('pusher_app_secret');
        $options    = $this->options();

        // Create Pusher object only if we don't already have one
        if (!isset($this->pusher))
        {
            // Create new Pusher object
            $this->pusher = new Pusher($app_key, $app_secret, $app_id, $options);
            log_message('debug', 'CI Pusher library loaded');

            // Set logger if debug is set to true
            if ($this->config->item('pusher_debug') === TRUE )
            {
                $this->pusher->set_logger(new ci_pusher_logger());
                log_message('debug', 'CI Pusher library debug ON');
            }
        }
    }

    /**
     * Trigger an event by providing event name and payload.
     * Optionally provide a socket ID to exclude a client (most likely the sender).
     *
     * @param   array   $channels   An array of channel names to publish the event on.
     * @param   string  $event
     * @param   mixed   $data       Event data
     * @param   int     $socket_id  [optional]
     * @param   bool    $debug      [optional]
     *
     * @return  bool|string
     */
    public function trigger($channels, $event, $data, $socket_id = null, $debug = FALSE, $already_encoded = FALSE)
    {
        return $this->pusher->trigger($channels, $event, $data, $socket_id, $debug, $already_encoded);
    }

    // --------------------------------------------------------------------

    /**
     * Creates a socket signature
     *
     * @param   int     $socket_id
     * @param   string  $custom_data
     *
     * @return  string
     */
    public function socket_auth($channel, $socket_id, $custom_data = FALSE)
    {
        return $this->pusher->socket_auth($channel, $socket_id, $custom_data);
    }

    // --------------------------------------------------------------------

    /**
     * Creates a presence signature (an extension of socket signing)
     *
     * @param   int     $socket_id
     * @param   string  $user_id
     * @param   mixed   $user_info
     *
     * @return  string
     */
    public function presence_auth($channel, $socket_id, $user_id, $user_info = FALSE)
    {
        return $this->pusher->presence_auth($channel, $socket_id, $user_id, $user_info);
    }

    // --------------------------------------------------------------------

    /**
     * GET arbitrary REST API resource using a synchronous http client.
     * All request signing is handled automatically.
     *
     * @param   string  $path   Path excluding /apps/APP_ID
     * @param   params  $array  API params (see http://pusher.com/docs/rest_api)
     *
     * @return  See Pusher API docs
     */
    public function get($path, $params = array())
    {
        return $this->pusher->get($path, $params);
    }

    // --------------------------------------------------------------------

    /**
     *  Fetch channel information for a specific channel.
     *
     * @param   string  $channel  The name of the channel
     * @param   array   $params   Additional parameters for the query e.g. $params = array( 'info' => 'connection_count' )
     *
     * @return  object
     */
    public function get_channel_info($channel, $params = array())
    {
        return $this->pusher->get_channel_info($channel, $params);
    }

    // --------------------------------------------------------------------

    /**
     * Fetch a list containing all channels
     *
     * @param   array  $params  Additional parameters for the query e.g. $params = array( 'info' => 'connection_count' )
     *
     * @return  array
     */
    public function get_channels($params = array())
    {
        return $this->pusher->get_channels($params);
    }

    // --------------------------------------------------------------------

    /**
     * Build optional option array
     *
     * @return  array
     */
    private function options()
    {
        $options['pusher_scheme']    = ($this->config->item('pusher_scheme')) ?: NULL;
        $options['pusher_host']      = ($this->config->item('pusher_host')) ?: NULL;
        $options['pusher_port']      = ($this->config->item('pusher_port')) ?: NULL;
        $options['pusher_timeout']   = ($this->config->item('pusher_timeout')) ?: NULL;
        $options['pusher_encrypted'] = ($this->config->item('pusher_encrypted')) ?: NULL;

        $options = array_filter($options);

        return $options;
    }

    // --------------------------------------------------------------------

    /**
    * Enables the use of CI super-global without having to define an extra variable.
    * I can't remember where I first saw this, so thank you if you are the original author.
    *
    * Copied from the Ion Auth library
    *
    * @access  public
    * @param   $var
    * @return  mixed
    */
    public function __get($var)
    {
        return get_instance()->$var;
    }

}

// --------------------------------------------------------------------

/**
 * Logger class
 *
 * Logs all messages to CodeIgniter log
 */
Class ci_pusher_logger {

    /**
     * Log Pusher log message to CodeIgniter log
     *
     * @param   string  $msg  The debug message
     */
    public function log($msg)
    {
        log_message('debug', $msg);
    }

    // --------------------------------------------------------------------

    /**
    * Enables the use of CI super-global without having to define an extra variable.
    * I can't remember where I first saw this, so thank you if you are the original author.
    *
    * Copied from the Ion Auth library
    *
    * @access  public
    * @param   $var
    * @return  mixed
    */
    public function __get($var)
    {
        return get_instance()->$var;
    }
}
