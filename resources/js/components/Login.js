import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';

export default class DutyList extends Component {
    render() {
        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-header">React Component</div>

                            <div className="card-body">
                                I'm a React component!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

if (document.getElementById('dutylist')) {
    ReactDOM.render(<DutyList />, document.getElementById('dutylist'));
}
