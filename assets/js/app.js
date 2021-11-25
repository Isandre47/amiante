import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import Welcome from "./Component/Welcome";
import axios from "axios";

class App extends Component {
    constructor(props) {
        super(props);
        this.state = {
            name: 'Idiot',
            users: []
        }
    }

    componentDidMount() {
        this.getUsers();
    }

    getUsers() {
        axios.get('http://amiante/users').then(users => {
            console.log(users);
            this.setState({users: users.data})
        })
    }

    render() {
        return (
            <div>
                <p>
                    Hello world!
                </p>
                <div>
                    <Welcome nom={this.state.name}/>
                    <ul>
                        { this.state.users.map(user =>
                            <li>{user.name}</li>
                        )}
                    </ul>
                </div>
            </div>
        )
    }
}

ReactDOM.render(<App/>, document.getElementById('root'));
