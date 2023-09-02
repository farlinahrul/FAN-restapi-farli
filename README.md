
# FAN restapi test




## Author

[@farlinahrul](https://www.github.com/farlinahrul)


## Requirement

 - [PHP 8.1.1](https://windows.php.net/download/)
 - [Laravel Framework 9.52.15](https://laravel.com/docs/9.x)
 - [Postgresql](https://www.postgresql.org/)
 - [Passport (Oauth2)](https://laravel.com/docs/10.x/passport)


## Result

### Database
- Migration: 
    - [users](https://github.com/farlinahrul/FAN-restapi-farli/blob/production/database/migrations/2014_10_12_000000_create_users_table.php)
    - [presences](https://github.com/farlinahrul/FAN-restapi-farli/blob/production/database/migrations/2023_09_01_072711_create_presences_table.php)
- Seeder: [user with presence](https://github.com/farlinahrul/FAN-restapi-farli/blob/production/database/seeders/DatabaseSeeder.php)
- Table users:
  ![image](https://github.com/farlinahrul/FAN-restapi-farli/assets/79825915/b3e7903e-0f04-4ccf-9811-9ca9bcab2b66)
- Table presences:
  ![image](https://github.com/farlinahrul/FAN-restapi-farli/assets/79825915/83b4e89a-2575-42c0-a2f1-c3b74c27e49f)

### RESTFUL API
- Register
    - Route: [api/v1/auth/register](https://github.com/farlinahrul/FAN-restapi-farli/blob/production/routes/ApiRoutes/AuthRoutes.php) 
    - [Controller](https://github.com/farlinahrul/FAN-restapi-farli/blob/production/app/Http/Controllers/Api/v1/Auth/RegisterController.php)
    - Example Request:
    ```json
    {
        "name": "Farli Nahrul Javier",
        "email": "farlynj@gmail.com",
        "password": "password",
        "supervisor_npp": 10001 // optional
    }
    ```
    - Example Result:
    ```json
    {
        "success": true,
        "message": "Success",
        "data": {
            "name": "Farli Nahrul Javier",
            "email": "farlynj@gmail.com",
            "supervisor_npp": "10001",
            "npp": 10012,
            "id": "9a07c1a7-5bc2-4a0b-860c-c8e8cb54055a",
            "updated_at": "2023-09-01T15:10:44.000000Z",
            "created_at": "2023-09-01T15:10:44.000000Z"
        }
    }
    ```
- Login
    - Route: [api/v1/auth/login](https://github.com/farlinahrul/FAN-restapi-farli/blob/production/routes/ApiRoutes/AuthRoutes.php) 
    - [Controller](https://github.com/farlinahrul/FAN-restapi-farli/blob/production/app/Http/Controllers/Api/v1/Auth/LoginController.php)
    - Example Request:
    ```json
    {
        "email": "user@mail.com",
        "password": "password",
        "state": "ky6VxWg1TyD33frnl2P79wtfW9SVnNilptyv0Jsr",
        "challenge": "mjkMMOVhSJXQk5tsG8Aepm6EQQqspfnLN17EBDyrUdU"
    }
    ```
    - Example Result:
    ```json
    {
        "success": true,
        "message": "Success",
        "data": {
            "state": "ky6VxWg1TyD33frnl2P79wtfW9SVnNilptyv0Jsr",
            "code": "def50200f676222bd6761c2d69a981d8ce303ca0499b5ae6784da9f4f003a7075f9dbae299ded1c8c7a639010d0869751610de1ff8b1f00393c3dcbd9e22b346dee62ecb2a2bfcf6894ab7749025cc2cced0e00115325c444b5ea2bfbe84f72f0b647ea4cebee80035bec0e11c9ff4384c8a4d382ad988437a29f1718f7833ad5d29a7302e4effb1ea05ca62e6a8213001dcc5c6a0f1a2c942265db80e56ac2f11b8e5b8b321ca412104c1e593d03b78840cbc18ae4415f5cbf5bf66655892b69a1aa88f69e75da1bf0b9b4ddc9003ca6b063fcc9f5d6f41c07b913d533c691244b1e413e27c9cdac973ce7107621cd9dd645be4ae50526440b07387b264e4617a0ac8d879b644813a9736fe7296d621ffcaa4fbb4591354a2299afac14f677309dc0f2dbe085c8fdc370275ae3fa4dbc701d33dc47178c1079292f5f13c0feb1102ca86b629d6542c7e87eb34cc0177e883e9ea0e30b96b969c461ee0f2fe9b58dfaa2c8e7c35aa944007c3720c7d7878adfdb77f0b47b667ae13fe2957cdf4f4390277ba89be55d9a04487da2e164e63445c60502971a04136a02bbaa9a417a1729a141d9a846a39211b7c709da3f5a7c55da0c5c61b93ef36b20aa81d7c4a0b65a58f1c34a773015348ef0df0fe96e553a041f587493b6d1021d564d0bd84"
        }
    }
    ```
- Authorize
    - Route: [api/v1/auth/authorize](https://github.com/farlinahrul/FAN-restapi-farli/blob/production/routes/ApiRoutes/AuthRoutes.php) 
    - [Controller](https://github.com/farlinahrul/FAN-restapi-farli/blob/production/app/Http/Controllers/Api/v1/Auth/AuthorizeController.php)
    - Example Request:
    ```json
    {
        // random string
        "verifier": "Z2ms8lDiauSlL8dB802J7G6BlzHXcWOHEpYEmmCSKRgqpj25ubWiDuQkocF9E2BS1kuuzozG2XzmenLEemL7L5JcSrRP3vm3vmnuKN3UhkJJmfh8dZ0p6KLYEecGU0hX",
        // code from /login
        "code": "def50200f676222bd6761c2d69a981d8ce303ca0499b5ae6784da9f4f003a7075f9dbae299ded1c8c7a639010d0869751610de1ff8b1f00393c3dcbd9e22b346dee62ecb2a2bfcf6894ab7749025cc2cced0e00115325c444b5ea2bfbe84f72f0b647ea4cebee80035bec0e11c9ff4384c8a4d382ad988437a29f1718f7833ad5d29a7302e4effb1ea05ca62e6a8213001dcc5c6a0f1a2c942265db80e56ac2f11b8e5b8b321ca412104c1e593d03b78840cbc18ae4415f5cbf5bf66655892b69a1aa88f69e75da1bf0b9b4ddc9003ca6b063fcc9f5d6f41c07b913d533c691244b1e413e27c9cdac973ce7107621cd9dd645be4ae50526440b07387b264e4617a0ac8d879b644813a9736fe7296d621ffcaa4fbb4591354a2299afac14f677309dc0f2dbe085c8fdc370275ae3fa4dbc701d33dc47178c1079292f5f13c0feb1102ca86b629d6542c7e87eb34cc0177e883e9ea0e30b96b969c461ee0f2fe9b58dfaa2c8e7c35aa944007c3720c7d7878adfdb77f0b47b667ae13fe2957cdf4f4390277ba89be55d9a04487da2e164e63445c60502971a04136a02bbaa9a417a1729a141d9a846a39211b7c709da3f5a7c55da0c5c61b93ef36b20aa81d7c4a0b65a58f1c34a773015348ef0df0fe96e553a041f587493b6d1021d564d0bd84"
    }
    ```
    - Example Result:
    ```json
    {
        "success": true,
        "message": "Success",
        "data": {
            "token_type": "Bearer",
            "expires_in": 31622400,
            "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5YTA3ZTAxMi0xYzczLTRhYTItOWFiZS0xZTQ5ZTk1NDU3YTYiLCJqdGkiOiI0NDg3YmZjNzA1YzE1NWY5OGI4ZDRhY2JlMjk5ZGE4MmZhNTdiYjg2ZjJhYjE4MzVkNzJhNDllYmI0MTAwMmZiNTM4ZmM5MjNmODBiODhiMiIsImlhdCI6MTY5MzU4ODgzNC4yMTQyNjQsIm5iZiI6MTY5MzU4ODgzNC4yMTQyNjYsImV4cCI6MTcyNTIxMTIzNC4wNjI5NDQsInN1YiI6IjlhMDdkZmViLTAxYTYtNGQ2ZC1iOWIxLTI4Mjc4YzIyYTYyNCIsInNjb3BlcyI6W119.CKPcBa0aoc5sezI6L9odQ5XeofntVkEuSA33ji9u1b7VX4QmUFJMp-T_f1Jq94Szm7eYn6qgcTcpCW8PJzLR-1MybUatKGAZXbx8cwX4h6VhMKo7mrVD6waFmeRpM4kzFQpd4NdTSFtWSb92-B4b3Z7KSNvxaDNYlg4Z0Rj_xTq4uwkY_fmkPRF_1yJkr8bqzkaGpyh8d1xU2P4tRBJEwxOXIx-P6nWu3OqYg_OItik3hc4kxrXZLasiaaT5MRLGaR4Yj9tCH8qk16MZPeFQkgxjCSma-sQtfCHzzDNtfYcR23teCAtZboR_ZryCYX3ULQ1MxwhvovuHhFlXq6y1v1IVrwG4uumyEn9cKqvbIZTg4q1BTUsE-MBlTe9Jcku6dgFhSzUUZ4ADlfH_AQnp3n4pNlaadzCMk3rxkyA2SrUG0wpoqYxid2sRnDev5Vo8AWhwiQ_e9r1BH-Bn1Amx9NAzKeVTjxp5p3CdreKfz0rs3w-KeH1FF0DYm2_2CFOLKCsjTww7r1Tc05PtfGVpscu8jDTogo18frxiYaqxKIp9GBVFm_-8H5kNiTsSAdDCK7NGG56niq-06iGEeGtS8PHo_oCJ6xgktwqbJbuTMRnPtHeD7vmGJJf-iSe5kktQKxiC-T3GXaliu9dNuGYlMrIgfWp9Nuvb2eRKdWz8sPM",
            "refresh_token": "def50200c94d95ba631a433c04941156d1fbad60c2186c98c569243e3bcf5d38bc4e7171856bc7dcc3f9926d194eadd565640ab9cd9f7da624bdb163ad0341b8bc501f102d9ca392d99079c66a5fb561dd887356e200196cd650fb06dfec2f19553e067c1fdd69d44f4a5735cb84d50f182a62572a4c9d88ec27dc900b821842a42ac7998b2a63444c31fc7e215a9cdd640ff61b02fcb3acca66aa50cfc6ca3ddad9e20f85cf53473b48cc3aa949d3320f56a7ab4fe7f040f3eec1e034d151c44577411a880a72e17ddf60155a058ed761e2e05bacd543a0858df52b4b8bb0a7a2a516e9c6545298ac9ebb7afba6d1bb148289fbe72711c71f1aa422765d4438fbe4b5f4522cee5ae0540038710aed040bb4003b74ca2873a6bc73f4e546ef3a05f97fb5761eb9b03a1edc328fced5a7a14590ebae8b5bc1687e9304d62b25a84984dfe19e5042493fdb3196d5b5652c0c23cca504890c0846cd15403c54c93abd3d7a5e799de37c44e8f3c72790220bdecb2c7caf99aaad3872c7600626691b2fefa52cd3138693b2c4e351574c3670352a9c914fbe1ee27e3adae415178a15f32d8a7ed0020fd3ff",
            "user": {
                "id": "9a07dfeb-01a6-4d6d-b9b1-28278c22a624",
                "name": "Lenore Parisian Sr.",
                "email": "user@mail.com",
                "npp": 10001,
                "supervisor_npp": null,
                "created_at": "2023-09-01T16:35:21.000000Z",
                "updated_at": "2023-09-01T16:35:21.000000Z",
                "deleted_at": null
            }
        }
    }
    ```
    
- Presence
    - [Route](https://github.com/farlinahrul/FAN-restapi-farli/blob/production/routes/ApiRoutes/PresenceRoutes.php) : 
        - GET api/v1/presence (All Presence)
            ```json
            {
                "success": true,
                "message": "Success",
                "data": [
                    {
                        "user_id": "9a07dfeb-01a6-4d6d-b9b1-28278c22a624",
                        "name": "Lenore Parisian Sr.",
                        "tanggal": "2023-09-01",
                        "waktu_masuk": "03:09::21",
                        "waktu_pulang": null,
                        "status_masuk": "REJECT",
                        "status_pulang": "REJECT"
                    },
                    {
                        "user_id": "9a07dfeb-08f3-42bb-be98-4e2c67da048b",
                        "name": "Linnie Senger",
                        "tanggal": "2023-09-01",
                        "waktu_masuk": "03:09::21",
                        "waktu_pulang": "04:09::21",
                        "status_masuk": "REJECT",
                        "status_pulang": "Approved"
                    }
                ]
            }
            ```
        - GET api/v1/my_presence (all my presence: based on auth user)
        - GET api/v1/my_presence_approval (all my presence approval: based on supervisor_npp)
        - POST api/v1/presence (insert data presence)
            ```json
            {
                "type": "IN",
                "time": "2023-09-01T08:00:00.000Z" // improvement: add timezone to prevent wrong time
            }
            ```
        - POST api/v1/approve/{id} (approve presence)
        - GET api/v1/presence_paginate - Improvement
        - GET api/v1/my_presence_paginate - Improvement
        - GET api/v1/my_presence_approval_paginate - Improvement
    - [Controller](https://github.com/farlinahrul/FAN-restapi-farli/blob/production/app/Http/Controllers/Api/v1/Auth/LoginController.php)

- [x] Buatlah aplikasi RESTFUL API yang dapat melakukan Insert dan Get Data dalam format json.
- [x] Disaat user melakukan insert ataupun get data, API harus melakukan validasi token terlebih dahulu.
- [x] Token didapatkan setelah user melakukan Login.
- [x] Data user hanya boleh di-approve oleh supervisor nya sendiri.
- [x] Data yang akan di-insert adalah data absensi.
- [x] Setiap hari user melakukan 2 kali absensi (masuk dan pulang, menjadi 2 baris di database).

### Improvement
- Seeder
- Pagination
- implement uuid
- Reusable component (ApiWrapper, Controller private function(on presence), Pagination)
