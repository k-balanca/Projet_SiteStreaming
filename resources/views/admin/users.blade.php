    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Liste des utilisateurs</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/admin_style.css') }}">
    </head>
    <body>
        <h1>Liste des utilisateurs</h1>
        <br>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                background-color: #111;
                color: #fff;
                border-radius: 8px;
                overflow: hidden;
            }

            thead {
                background-color: #1f1f1f;
            }

            thead th {
                padding: 12px;
                text-align: left;
                font-weight: 600;
                border-bottom: 2px solid #333;
            }

            tbody td {
                padding: 12px;
                border-bottom: 1px solid #222;
            }

            tbody tr:hover {
                background-color: #2a2a2a;
                transition: 0.2s;
            }

            tbody tr:nth-child(even) {
                background-color: #181818;
            }

            tbody tr:nth-child(even):hover {
                background-color: #2a2a2a;
            }

            td[colspan] {
                text-align: center;
                color: #aaa;
                padding: 20px;
            }

            h1 {
                color: #fff;
                font-weight: 600;
            }
        </style>
            <table >
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Créé le</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Aucun utilisateur</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
    </body>
    </html>
        
        

