class Pizzas extends React.Component {
    constructor(props) {
        super(props);
        this.state = {pizzas: []};
    }

    componentDidMount() {
        axios.get('/pizzas').then(res => {
            this.setState({ pizzas: res.data });
        });
    }

    deletePizza(id) {
        axios({
            method: 'post',
            url: '/pizza/delete/' + id
        }).then(res => {
            this.props.history.go(0);
        });
    }

    render() {
        return (
            <div className="container">
                {this.state.pizzas.map((pizza) => (  
                    <div className="row" key={pizza.id}>
                        <div className="col">
                            {pizza.name}
                        </div>
                        <div className="col">
                            <Link className="btn btn-primary" to={`/pizza/${pizza.id}`}>edit</Link>
                        </div>
                        <div className="col">
                            <button className="btn btn-danger" onClick={this.deletePizza.bind(this, pizza.id)}>Delete</button>
                        </div>
                        <div className="col">
                            <Link className="btn btn-warning" to={`/pizza/${pizza.id}/ingredients`}>ingredients</Link> 
                        </div>
                    </div>
                ))}
                <div>
                   <Link className="btn btn-success" to="/pizza">new</Link>
                </div>
            </div>
        );
    }
};