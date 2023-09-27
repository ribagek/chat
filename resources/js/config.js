export default {
  echo: {
    broadcaster: "pusher",
    key: "multidesk",
    wsHost: window.location.hostname,
    wsPort: 6001,
    cluster: "mt1",
    forceTLS: false,
    disableStats: true,
  },
}
