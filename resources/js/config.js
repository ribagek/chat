export default {
  echo: {
    broadcaster: "pusher",
    key: "multidesk",
    wsHost: window.location.hostname,
    wssHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
    cluster: "mt1",
    enabledTransports: ['ws', 'wss'],
  },
}
