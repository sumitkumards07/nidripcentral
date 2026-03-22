FROM node:18-slim

WORKDIR /app

# Copy package files and install dependencies
COPY package*.json ./
RUN npm ci --omit=dev

# Copy entire application
COPY . .

# Expose the port Render uses
EXPOSE 10000

# Start the server
CMD ["node", "server.js"]
