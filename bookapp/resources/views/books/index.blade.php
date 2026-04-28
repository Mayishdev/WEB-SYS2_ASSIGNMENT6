<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Catalog | Cedric Johanns C. Sorrera</title>
    <style>
        
        :root {
            --paper-bg: #fdfcf8;      
            --canvas-bg: #f4f1ea;     
            --text-main: #2c2c2c;     
            --accent-gold: #a68a64;   
            --border-color: #e0dcd0;  
            --delete-red: #9e3d3d;    
        }


        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            background-color: var(--canvas-bg);
            color: var(--text-main);
            line-height: 1.6;
            margin: 0;
            padding: 60px 20px;
        }

        .container {
            max-width: 850px;
            margin: 0 auto;
            background: var(--paper-bg);
            padding: 60px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            border: 1px solid var(--border-color);
            border-radius: 2px;
        }

        header {
            text-align: center;
            margin-bottom: 50px;
        }

        header h3 {
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-size: 0.85rem;
            color: var(--accent-gold);
            margin-bottom: 8px;
        }

        header h1 {
            font-size: 2.8rem;
            margin: 0;
            display: inline-block;
            border-bottom: 2px solid var(--text-main);
            padding-bottom: 15px;
        }


        .action-header {
            display: flex;
            justify-content: center;
            margin-bottom: 50px;
        }

        .add-link {
            text-decoration: none;
            color: var(--paper-bg);
            background: var(--text-main);
            padding: 14px 35px;
            font-family: sans-serif;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 2px;
            transition: all 0.3s ease;
            border: 1px solid var(--text-main);
        }

        .add-link:hover {
            background: transparent;
            color: var(--text-main);
            transform: translateY(-2px);
        }


        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        li {
            padding: 25px 0;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background 0.2s ease;
        }

        li:hover {
            background-color: rgba(166, 138, 100, 0.03);
        }

        .book-info {
            flex-grow: 1;
        }

        .book-title {
            font-size: 1.3rem;
            font-weight: 700;
            display: block;
            margin-bottom: 4px;
        }

        .book-meta {
            font-style: italic;
            color: #666;
            font-size: 1rem;
        }


        .actions {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .btn-edit {
            text-decoration: none;
            color: var(--text-main);
            font-size: 0.9rem;
            font-weight: 600;
            border-bottom: 1px solid var(--text-main);
            transition: color 0.2s;
        }

        .btn-edit:hover {
            color: var(--accent-gold);
            border-color: var(--accent-gold);
        }

        button.btn-delete {
            background: none;
            border: none;
            color: var(--delete-red);
            cursor: pointer;
            font-family: 'Georgia', serif;
            font-style: italic;
            font-size: 0.9rem;
            padding: 0;
            opacity: 0.8;
            transition: opacity 0.2s;
        }

        button.btn-delete:hover {
            opacity: 1;
            text-decoration: underline;
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .container { padding: 30px; }
            li { flex-direction: column; align-items: flex-start; gap: 15px; }
            .actions { width: 100%; justify-content: flex-start; }
        }
    </style>
</head>
<body>

    <div class="container">
        <header>
            <h3>Cedric Johanns C. Sorrera</h3>
            <h1>All Books</h1>
        </header>

        <div class="action-header">
            <a href="{{ route('books.create') }}" class="add-link">ADD NEW BOOK</a>
        </div>

        <ul>
            @foreach ($books as $book)
            <li>
                <div class="book-info">
                    <span class="book-title">{{ $book->title }}</span>
                    <span class="book-meta">by {{ $book->author }} • {{ $book->published_date }}</span>
                </div>

                <div class="actions">
                    <a href="{{ route('books.edit', $book->id) }}" class="btn-edit">Edit</a>
                    
                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you wish to remove this volume?')">Delete</button>
                    </form>
                </div>
            </li>
            @endforeach
        </ul>
    </div>

</body>
</html>