FROM laravelsail/php83-composer

# Install required PHP extensions and system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-install intl pdo pdo_mysql zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www/html

# Set default command to run Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
