# Base image
FROM node:17-alpine

# Set the working directory in the container
WORKDIR /app

# add `/app/node_modules/.bin` to $PATH
ENV PATH="/app/node_modules/.bin:$PATH"

# Copy package.json and package-lock.json to the working directory
COPY ui/package*.json ./

# Install dependencies
RUN npm install

# Copy the rest of the application code
COPY ui .

# Expose the desired port (e.g., 3000 for React's development server)
EXPOSE 3000

# Start the development server
CMD ["npm", "start"]
