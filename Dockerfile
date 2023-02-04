FROM php:8.2.1-cli-bullseye

WORKDIR /app

RUN apt-get update && apt-get install -y chromium \
	&& curl -L https://github.com/dnitsch/uistrategy/releases/download/v0.2.1/uiseeder-linux -o uiseeder

COPY index.php paypal.yml ./

CMD /bin/sh -c "sed -i \"s%{{ PAYPAL_URL }}%\$PAYPAL_URL%\" paypal.yml && chmod u+x ./uiseeder && ./uiseeder -v -i paypal.yml && php index.php"
