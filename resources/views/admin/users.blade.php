    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        @extends('admin.admin')
        @section('content')
            <h1>Liste des utilisateurs</h1>

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
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p>{{$users->links()}}</p>
        @endsection
    </body>
    </html>
