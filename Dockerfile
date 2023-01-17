FROM php:8.2.1-cli-bullseye

WORKDIR /app

COPY index.php index.js package.json package-lock.json .

RUN apt-get update \
	&& apt install -y nodejs gconf-service libasound2 libatk1.0-0 libc6 libcairo2 libcups2 libdbus-1-3 libexpat1 libfontconfig1 libgcc1 libgconf-2-4 libgdk-pixbuf2.0-0 libglib2.0-0 libgtk-3-0 libnspr4 libpango-1.0-0 libpangocairo-1.0-0 libstdc++6 libx11-6 libx11-xcb1 libxcb1 libxcomposite1 libxcursor1 libxdamage1 libxext6 libxfixes3 libxi6 libxrandr2 libxrender1 libxss1 libxtst6 ca-certificates fonts-liberation libnss3 lsb-release xdg-utils wget curl \
	&& curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - \
	&& npm ci

CMD /bin/sh -c "./node_modules/.bin/domcurl $PAYPAL_URL > $PAYPAL_FILE && php index.php"
