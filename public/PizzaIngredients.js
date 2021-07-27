class PizzaIngredients extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            pizzaid: props.match.params.id,
            pizza: null,
            ingredients: [],
            availableIngredients: []
        };
    }

    componentDidMount() {
        axios.get('/pizza/' + this.state.pizzaid + '/ingredients').then(res => {
            this.setState({
                pizza: res.data.pizza,
                ingredients: res.data.ingredients,
                availableIngredients: res.data.availableIngredients,
            });
        });
    }

    addIngredient(pizzaid, ingredientid) {
        axios({
            method: 'post',
            url: '/pizza/' + pizzaid + '/ingredient/add/' + ingredientid
        }).then(res => {
            this.props.history.go(0);
        });
    }

    removeIngredient(pizzaid, ingredientid) {
        axios({
            method: 'post',
            url: '/pizza/' + pizzaid + '/ingredient/remove/' + ingredientid
        }).then(res => {
            this.props.history.go(0);
        });
    }

    ingredientsPrice() {
        var price = 0;
        this.state.ingredients.forEach(function(ingredient) {
            price += parseFloat(ingredient.price);
        });
        return price;
    }

    totalPrice() {
        return Math.round(this.ingredientsPrice() * 1.5 * 100) / 100;
    }

    render() {
        const pizza = this.state.pizza;
        const ingredients = this.state.ingredients;
        const availableIngredients = this.state.availableIngredients;
        return (
            <div className="container">
                {pizza ? (
                    <span>
                        <div className="row">
                            <div className="col"><h1>{pizza.name}</h1></div>
                        </div>
                        <div className="row">
                            <div className="col"><h3>Available</h3></div>
                            <div className="col"><h3>Used</h3></div>
                        </div>
                        <div className="row">
                            <div className="col">
                                <div className="container-fluid">
                                {this.state.availableIngredients.map((availableIngredient) => (  
                                    <div className="row" key={availableIngredient.id}>
                                        <div className="col">
                                            {availableIngredient.name} - {availableIngredient.price}
                                        </div>
                                        <div className="col">
                                            <button className="btn btn-primary" onClick={this.addIngredient.bind(this, pizza.id, availableIngredient.id)}>Add</button>
                                        </div>
                                    </div>
                                ))}
                                </div>
                            </div>
                            <div className="col">
                                <div className="container-fluid">
                                {this.state.ingredients.map((ingredient) => (  
                                    <div className="row" key={ingredient.id}>
                                        <div className="col">
                                            {ingredient.name} - {ingredient.price}
                                        </div>
                                        <div className="col">
                                            <button className="btn btn-danger" onClick={this.removeIngredient.bind(this, pizza.id, ingredient.id)}>Remove</button>
                                        </div>
                                    </div>
                                ))}
                                </div>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col">
                                Ingredients price: <strong>{this.ingredientsPrice()} €</strong>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col">
                                Total price (+50%): <strong>{this.totalPrice()} €</strong>
                            </div>
                        </div>
                    </span>
                ) : (
                    <div>Loading...</div>
                )}
            </div>
        );
    }
}