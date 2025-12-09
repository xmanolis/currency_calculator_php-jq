# PHP Currency Converter (JSON API + Proxy)

The goal of the project is to show architecture commonly used in real world applications and how I can
write PHP code without the help of a framework or other dependencies.
---

## Server Side (Internal API)

The server-side code is located in the `/service` folder.  
This part of the project exposes a simple JSON API with two endpoints:

- `/service/available_currencies.php`
- `/service/converter.php`

The internal API fetches live currency rates from a free external service
and returns the results in a clean JSON format.

---

## Proxy Layer

The `/proxy` folder contains two small PHP files that act as a backend-for-frontend (BFF).  
The frontend sends requests to `/proxy/...`, and the proxy forwards them to the internal API.

This way we avoid the CORS issues and, also, we hide the API from the browser.

---

## Client Side

The client is located in the `/public` folder.  
It contains the user-facing HTML and JavaScript.

The JS code sends requests to the proxy layer, which then communicates with the JSON API.

---

## How to Run

1. Place the project in any PHP-enabled environment.
2. Open `/public/index.html` in the browser.
3. The converter will communicate with the proxy and internal service automatically.

This project is intentionally kept simple to focus on code clarity and architecture.
