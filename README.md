<p align="center"><h1>Cost Explorer</h1></p>

## Usage

### Start Laravel App
php artisan serve

### Test API routes [Change the port accordingly]
**Endpoint:** http://127.0.0.1:8000/api/explorer  
**Output:** Cost data of all the clients and their projects  

**Endpoint:** http://127.0.0.1:8000/api/explorer?client_id[]=1&client_id[]=2  
**Output:** Cost data of clients 1 and 2 and all their projects  

**Endpoint:** http://127.0.0.1:8000/api/explorer?cost_type_id[]=1&cost_type_id[]=10  
**Output:** Cost data with cost types 1 and 10 for all clients (and their projects)  

**Endpoint:** http://127.0.0.1:8000/api/explorer?cost_type_id[]=7&project_id[]=32&project_id[]=16  
**Output:** Cost data with cost types 1 for clients which have projects 16 and 32  


## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
