after run 
$ composer install
$ php artisan key:generate
$ php artisan migrate

you can create company with this api
POST /api/v1/companies

and get all companty by this
GET /api/v1/companies

create,edit,show and list of contact hire
GET /api/v1/contacts
POST /api/v1/contacts
GET /api/v1/contacts/{contact}
PATCH /api/v1/contacts/{contact}

add one or more contact to company
PATCH companies/{company}/add-contact

show company contatcs list
GET /companies/{company}/contacts

and search by name
GET /companies/search
