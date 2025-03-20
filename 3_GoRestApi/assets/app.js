/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

import axios from 'axios';


axios.defaults.baseURL = process.env.BASE_URL;
axios.defaults.headers = {
    ...axios.defaults.headers,
    'Accept': 'application/json',
};