class Ingredients extends React.Component {
    constructor(props) {
        super(props);
        this.state = {ingredients: []};
    }

    componentDidMount() {
        axios.get('/ingredients').then(res => {
            this.setState({ ingredients: res.data });
        });
    }

    deleteIngredient(id) {
        axios({
            method: 'post',
            url: '/ingredient/delete/' + id
        }).then(res => {
            this.props.history.go(0);
        });
    }

    render() {
        return (
            <div className="container">    
                {this.state.ingredients.map((ingredient) => (  
                    <div className="row" key={ingredient.id}>
                        <div className="col">
                            {ingredient.name} - {ingredient.price} €
                        </div>
                        <div className="col">
                            <Link className="btn btn-primary" to={`/ingredient/${ingredient.id}`}>edit</Link>
                        </div>
                        <div className="col">
                            <button className="btn btn-danger" onClick={this.deleteIngredient.bind(this, ingredient.id)}>Delete</button>
                        </div>    
                    </div>
                ))}
                <div>
                   <Link className="btn btn-success" to="/ingredient">new</Link>
                </div>
            </div>
        );
    }
};