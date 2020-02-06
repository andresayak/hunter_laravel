import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { Button, Form, FormGroup, Label, Input, FormText, Table, Modal, ModalHeader, ModalBody, ModalFooter } from 'reactstrap';

export default class Main extends Component {
        
    constructor(props) {
        super(props);
        this.state = {name: '', domains: '', domain: null, items: [], isLoaded: false, isShowModal: false};

        this.handleChangeName = this.handleChangeName.bind(this);
        this.handleChangeDomain = this.handleChangeDomain.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }
    
    handleChangeName(event) {
        this.setState({name: event.target.value});
    }

    handleChangeDomain(event) {
        this.setState({domains: event.target.value});
    }

    handleSubmit() {
        fetch("/api/add", {
            method: "post",
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                name: this.state.name,
                domains: this.state.domains
            })
        }).then(res => res.json())
        .then(response => {
            this.fetchInfo(response.id);
        });
    }
    
    fetchInfo(id) {
        fetch("/api/item/"+id)
            .then(res => res.json()).then(response => {
                this.state.items.push(response);
                this.setState({
                    items: this.state.items
                });
            });
    }
    
    componentDidMount() {
        fetch("/api/items")
                .then(res => res.json())
                .then((result) => {
                    this.setState({
                        items: result
                    });
                });
    }

    getDomainInfo(id) {
        return fetch("/api/domain/"+id)
                .then(res => res.json())
                .then((result) => {
                    this.setState({
                        isShowModal: true,
                        domain: result
                    });
                });
    }
    removeItem(id) {
        fetch("/api/item/"+id+'/remove')
                .then(res => res.json())
                .then((result) => {
                    var items = this.state.items.filter(item => item.id !== id);
                    this.setState({
                        items: items
                    });
                });
    }
    render() {
        
        return (
            <div>
                <div className="container">
                    {this.state.isLoaded?
                        <div className='loader'></div>:null
                    }
                    <div className="row justify-content-center">
                        <div className="col-md-8">
                            <FormGroup>
                                <Label for="inputName">Name</Label>
                                <Input type="text" name="name" id="inputName" placeholder="with a placeholder" onChange={this.handleChangeName}/>
                            </FormGroup>
                            <FormGroup>
                                <Label for="inputDomains">Domains</Label>
                                <Input type="textarea" name="domains" id="inputDomains" onChange={this.handleChangeDomain}/>
                            </FormGroup>
                            <Button color="success" onClick={() => this.handleSubmit()}>Save</Button>
                        </div>
                    </div>
                    <div className='p-2'>
                        {this.renderList()}
                    </div>
                </div>
                {this.renderModal()}
            </div>
        );
    }
    
    renderModal() {
        return (<Modal isOpen={this.state.isShowModal}>
            {this.state.domain?
                <div>
                    <ModalHeader>Domain {this.state.domain.domain_name}</ModalHeader>
                    <ModalBody>
                        {
                            this.state.domain.contacts.length?this.renderDomainContactList(this.state.domain.contacts):
                            <div> - - empty list - - </div>
                        }
                    </ModalBody>
                    <ModalFooter>
                        <Button color="secondary" onClick={() => this.hideDomainModalInfo()}>Cancel</Button>
                    </ModalFooter>
                </div> : null}
            </Modal>);
    }
    
    renderList(){
        return (
            <Table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Domains</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                {this.state.items.map(item => (
                    <tr key={item.id}>
                        <td>{item.id}</td>
                        <td>{item.name}</td>
                        <td>
                            {this.renderDomainList(item.domains)}
                        </td>
                        <td>
                            <Button color='danger' onClick={() => this.removeItem(item.id)}>Remove</Button>
                        </td>
                    </tr>
                ))}
                </tbody>
            </Table>);
    }
    
    renderDomainList(domains) {
        return (<ul>
                {domains.map(item => (
                    <li key={item.id}>{item.domain_name} <Button color='info' onClick={() => this.showDomainModalInfo(item.id)}>info</Button></li>
               ))}
            </ul>);
    }
    
    renderDomainContactList(contacts) {
        return (<ul>
                {contacts.map(item => (
                    <li key={item.id}>First name: <b>{item.first_name}</b>, Last name: <b>{item.last_name}</b>, Email: <b>{item.email}</b></li>
               ))}
            </ul>);
    }
    
    showDomainModalInfo(domain_id) {
        this.getDomainInfo(domain_id);
    }
    hideDomainModalInfo() {
        this.setState({
                isShowModal: false
            });
    }
}

if (document.getElementById('app')) {
    ReactDOM.render(<Main />, document.getElementById('app'));
}
