import Echo from "laravel-echo"
import config from '../config'

window.Pusher = require("pusher-js");

if (! window.Echo) {
  window.Echo = new Echo(config.echo)
}
