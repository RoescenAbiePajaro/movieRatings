import express from 'express';
import axios from 'axios';
const app = express();
const port = 3000;
app.use(express.json());

app.get('/api/*', async (req, res) => {
    const url = `http://movie-ratings.infinityfreeapp.com${req.originalUrl.replace('/api', '')}`;
    try {
        const response = await axios.get(url);
        res.json(response.data);
    } catch (error) {
        res.status(500).json({ error: 'Failed to fetch data', details: error.message });
    }
});
app.post('/api/*', async (req, res) => {
    const url = `http://movie-ratings.infinityfreeapp.com${req.originalUrl.replace('/api', '')}`;
    try {
        const response = await axios.post(url, req.body);
        res.json(response.data);
    } catch (error) {
        res.status(500).json({ error: 'Failed to post data', details: error.message });
    }
});

app.listen(port, () => {
    console.log(`Proxy server running at http://localhost:${port}`);
});
