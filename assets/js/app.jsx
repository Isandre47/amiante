import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import Navbar from "./Component/Navbar";

class App extends Component {
    render() {
      return (
          <div className={'container-fluid'}>
            <div className={'bg-secondary'}>
              <Navbar />
            </div>
          </div>
      )
    }
}

ReactDOM.render(<App />, document.getElementById('root'));
