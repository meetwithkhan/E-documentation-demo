**For Every New Project — Just Do This:**

git clone <your-repo> new-project-name
cd new-project-name
composer install
npm install
cp .env.example .env
php artisan key:generate

**# update .env with new DB name**

php artisan migrate


npm run build
php artisan serve

**Now For a New Project — Just Edit config/brand.php**

return [
    'name'          => 'MediTrack',        // ← Change app name
    'tagline'       => 'Hospital System',
    'logo_initials' => 'MT',
    'logo_type'     => 'image',            // ← Use your own logo image
    'logo_image'    => 'images/logo.png',  // ← Put in public/images/
    'brand_color'   => 'emerald',          // ← Change brand color
    'location'      => 'Dhaka Medical College, Dhaka.',
    'register_name' => 'Medicine Stock Register',
];


**Then clear config cache:**
php artisan config:clear
php artisan cache:clear
npm run build
