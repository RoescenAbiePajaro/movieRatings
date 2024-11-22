import express from 'express';  // Express module import

const app = express();
const port = 3000;

// Mock movie data
let movies = [
    { id: 1, title: "John Wick(2014)", rating: 8.8, image: "/assets/images/johnwick.jpg", description: "An ex-hitman comes out of retirement to track down the gangsters that killed his dog and took everything from him.", userRating: null },
    { id: 2, title: "Transformer One", rating: 8.6, image: "/assets/images/Transformers_One_Official_Poster.jpg", description: "The battle between Autobots and Decepticons continues.", userRating: null },
    { id: 3, title: "Nobody", rating: 9.0, image: "/assets/images/nobody.jpg", description: "A family man who is overlooked and underestimated unleashes his fury on those who wronged him.", userRating: null },
    { id: 4, title: "Blade Runner", rating: 8.5, image: "/assets/images/MV5BNzA1Njg4NzYxOV5BMl5BanBnXkFtZTgwODk5NjU3MzI@._V1_.jpg", description: "A blade runner must pursue and terminate four replicants who stole a ship in space and have returned to Earth.", userRating: null },
];

// Serve static files (like images) from the public folder
app.use(express.static('public'));

// Middleware to parse JSON bodies
app.use(express.json());

// Get movie by ID
app.get('/api/movies/:id', (req, res) => {
    const movie = movies.find(movie => movie.id == req.params.id);
    if (movie) {
        res.json(movie); // Send movie data as JSON
    } else {
        res.status(404).send('Movie not found'); // Handle not found
    }
});

// Rate movie by ID
app.post('/api/movies/:id/rate', (req, res) => {
    const movie = movies.find(movie => movie.id == req.params.id);
    if (movie) {
        movie.userRating = req.body.rating; // Update the user rating
        res.status(200).send('Rating submitted'); // Success
    } else {
        res.status(404).send('Movie not found'); // Handle not found
    }
});

// Start server
app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});
