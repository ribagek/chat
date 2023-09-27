import App from "./App"
import { createPinia } from 'pinia'
import './.plugins'

Nova.booting((app, store) => {
  const pinia = createPinia()

  app.use(pinia)

  Nova.inertia("Chat", App)
})
