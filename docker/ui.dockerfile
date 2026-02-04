FROM node:20.20.0-bookworm-slim

WORKDIR /app

CMD sh -c "npm install && npm run dev"