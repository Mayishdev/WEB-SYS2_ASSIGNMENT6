<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Volume | {{ $book->title }}</title>
    <style>
        /* --- Consistent Book Vibe Variables --- */
        :root {
            --paper-bg: #fdfcf8;
            --canvas-bg: #f4f1ea;
            --text-main: #2c2c2c;
            --accent-gold: #a68a64;
            --border-color: #e0dcd0;
            --input-bg: #ffffff;
        }

        body {
            font-family: 'Georgia', serif;
            background-color: var(--canvas-bg);
            color: var(--text-main);
            margin: 0;
            padding: 60px 20px;
            display: flex;
            justify-content: center;
        }

        .form-container {
            max-width: 500px;
            width: 100%;
            background: var(--paper-bg);
            padding: 50px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            border: 1px solid var(--border-color);
            border-radius: 2px;
        }

        h1 {
            font-size: 2rem;
            text-align: center;
            margin-top: 0;
            margin-bottom: 30px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 15px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: bold;
            margin-bottom: 8px;
            color: var(--accent-gold);
            font-family: sans-serif; /* Mixing sans with serif for a professional look */
        }

        input {
            width: 100%;
            padding: 12px;
            box-sizing: border-box;
            border: 1px solid var(--border-color);
            background-color: var(--input-bg);
            font-family: 'Georgia', serif;
            font-size: 1rem;
            color: var(--text-main);
            transition: border-color 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: var(--accent-gold);
            background-color: #fff;
        }

        .button-group {
            text-align: center;
            margin-top: 40px;
        }

        button {
            background: var(--text-main);
            color: var(--paper-bg);
            border: 1px solid var(--text-main);
            padding: 14px 40px;
            font-family: sans-serif;
            font-size: 0.8rem;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background: transparent;
            color: var(--text-main);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #666;
            font-size: 0.85rem;
            font-style: italic;
        }

        .back-link:hover {
            color: var(--accent-gold);
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h1>Edit Volume</h1>

        <form action="{{ route('books.update', $book->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="{{ $book->title }}" required>
            </div>

            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" id="author" name="author" value="{{ $book->author }}" required>
            </div>

            <div class="form-group">
                <label for="published_date">Published Date</label>
                <input type="date" id="published_date" name="published_date" value="{{ $book->published_date }}" required>
            </div>

            <div class="button-group">
                <button type="submit">Save Changes</button>
            </div>

            <a href="{{ route('books.index') }}" class="back-link">Return to Catalog</a>
        </form>
    </div>

</body>
</html>