import React, {Component} from "react";
import axios from "axios";

class Welcome extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div>
                <h2>Bonjour, {this.props.nom}</h2>
            </div>
        )
    }
}

export default Welcome
