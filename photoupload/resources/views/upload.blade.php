<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Photo Studio</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --bg-color: #f9fafb;
            --card-bg: #ffffff;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --border-color: #e5e7eb;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            margin: 0;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            max-width: 1000px;
            width: 100%;
        }

        /* Form Styling */
        .upload-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 50px;
        }

        @media (max-width: 768px) {
            .upload-section { grid-template-columns: 1fr; }
        }

        .card {
            background: var(--card-bg);
            padding: 24px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            font-size: 1.25rem;
            margin-top: 0;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        input[type="file"] {
            padding: 10px;
            border: 2px dashed var(--border-color);
            border-radius: 8px;
            cursor: pointer;
            transition: border-color 0.3s;
        }

        input[type="file"]:hover {
            border-color: var(--primary-color);
        }

        button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background-color: var(--primary-hover);
        }

        /* Success Message */
        .alert {
            background-color: #ecfdf5;
            color: #065f46;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #a7f3d0;
        }

        /* Gallery Styling */
        .gallery-header {
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 10px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: transform 0.3s;
            height: 200px;
        }

        .gallery-item:hover {
            transform: translateY(-5px);
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* This keeps images uniform */
            display: block;
        }
    </style>
</head>
<body>

<div class="container">
    
    @if (session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="upload-section">
        <div class="card">
            <h1>Single Upload</h1>
            <form action="{{ route('photo.store.single') }}" method="POST" enctype="multipart/form-data" class="form-group">
                @csrf
                <input type="file" name="image" required>
                <button type="submit">Upload Photo</button>
            </form>
        </div>

        <div class="card">
            <h1>Multiple Upload</h1>
            <form action="{{ route('photo.store.multiple') }}" method="POST" enctype="multipart/form-data" class="form-group">
                @csrf
                <input type="file" name="image[]" multiple required>
                <button type="submit">Upload Collection</button>
            </form>
        </div>
    </div>

    <div class="gallery-header">
        <h2>Photo Gallery</h2>
        <span style="color: var(--text-muted); font-size: 0.9rem;">Total: {{ \App\Models\Photo::count() }}</span>
    </div>

    <div class="gallery-grid">
        @foreach(\App\Models\Photo::all() as $photo)
            <div class="gallery-item">
                <img src="{{ asset('images/'.$photo->image) }}" alt="Uploaded Image">
            </div>
        @endforeach
    </div>

</div>

</body>
</html>