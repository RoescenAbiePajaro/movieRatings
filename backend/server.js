// backend/server.js
import express from 'express';

const app = express();
const port = 3000;

let movies = [
    { id: 1, title: "John Wick(2014)", rating: 8.8, image: "assets/images/johnwick.jpg", description: "An ex-hitman comes out of retirement to track down the gangsters that killed his dog and took everything from him.", userRating: null },
    { id: 2, title: "Transformer One", rating: 8.6, image: "assets/images/Transformers_One_Official_Poster.jpg", description: "The battle between Autobots and Decepticons continues.", userRating: null },
    { id: 3, title: "Nobody", rating: 9.0, image: "assets/images/nobody.jpg", description: "A family man who is overlooked and underestimated unleashes his fury on those who wronged him.", userRating: null },
    { id: 4, title: "Blade Runner", rating: 8.5, image: "assets/images/MV5BNzA1Njg4NzYxOV5BMl5BanBnXkFtZTgwODk5NjU3MzI@._V1_.jpg", description: "A blade runner must pursue and terminate four replicants who stole a ship in space and have returned to Earth.", userRating: null },
];

app.use(express.json());

app.get('/api/movies/:id', (req, res) => {
    const movie = movies.find(movie => movie.id == req.params.id);
    res.json(movie);
});

app.post('/api/movies/:id/rate', (req, res) => {
    const movie = movies.find(movie => movie.id == req.params.id);
    if (movie) {
        movie.userRating = req.body.rating;
        res.status(200).send('Rating submitted');
    } else {
        res.status(404).send('Movie not found');
    }
});

app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});