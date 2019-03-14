FROM node

WORKDIR /app

RUN npm install -g --silent \
    yarn \
    vue-cli; \
    npm install 

EXPOSE 8080

CMD ["npm", "run", "dev"]
