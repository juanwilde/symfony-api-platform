import React, { useState } from 'react';
import './App.css';
import FacebookLogin from 'react-facebook-login';
import axios from 'axios';

function App() {
  axios.defaults.baseURL = process.env.REACT_APP_BASE_URL;

  const [success, setSuccess] = useState(null);
  const [error, setError] = useState(null);

  const responseFacebook = (response) => {
    axios.post(`${process.env.REACT_APP_API_PATH}/users/facebook/auth`, { accessToken: response.accessToken })
      .then(res => setSuccess(res.data.token))
      .catch(err => setError(err.message));
  }

  return (
    <div className="App">
      <header className="App-header">
        <h2>Facebook Login Tester</h2>
        <FacebookLogin
          appId={process.env.REACT_APP_FACEBOOK_CLIENT_ID}
          autoLoad={true}
          reauthenticate={true}
          fields="name,email,picture"
          callback={responseFacebook} />
        <br />
        <br />
        {
          null !== success
            ? <p className={'success'}>{success}</p>
            : null !== error
            ? <p>{error}</p>
            : null
        }
      </header>
    </div>
  );
}

export default App;
