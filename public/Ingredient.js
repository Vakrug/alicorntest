class Ingredient extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            ingredientid: props.match.params.id,
            ingredient: null,
            name: '',
            price: 0
        };

        this.handleNameChange = this.handleNameChange.bind(this);
        this.handlePriceChange = this.handlePriceChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    componentDidMount() {
        if (this.state.ingredientid) {
            axios.get('/ingredient/' + this.state.ingredientid).then(res => {
                this.setState({
                    ingredient: res.data,
                    name: res.data.name,
                    price: res.data.price
                });
            });
        }
    }

    handleNameChange(event) {
        this.setState({name: event.target.value});
    }

    handlePriceChange(event) {
        this.setState({price: event.target.value});
    }

    handleSubmit(event) {
        event.preventDefault();
        var bodyFormData = new FormData();
        bodyFormData.append('name', this.state.name);
        bodyFormData.append('price', this.state.price);

        if (this.state.ingredientid) {
            axios({
                method: 'post',
                url: '/ingredient/' + this.state.ingredientid,
                data: bodyFormData,
            }).then(res => {
                this.props.history.push('/ingredients');
            });
        } else {
            axios({
                method: 'post',
                url: '/ingredient',
                data: bodyFormData,
            }).then(res => {
                this.props.history.push('/ingredients');
            });
        }
    }

    render() {
        const ingredient = this.state.ingredient;
        const ingredientid = this.state.ingredientid;
        return (
            <div className="container">
                {ingredient || !ingredientid ? (
                    <form onSubmit={this.handleSubmit}>
                        <div>
                            <label htmlFor="name-input" className="form-label">Name</label>
                            <input id="name-input" className="form-control" type="text" name="name" value={this.state.name} onChange={this.handleNameChange} />
                        </div>
                        <div>
                            <label htmlFor="price-input" className="form-label">Price</label>
                            <input id="price-input" className="form-control" type="number"name="price" step="0.1" value={this.state.price} onChange={this.handlePriceChange} />
                        </div>
                        <input type="submit" value="submit" className="btn btn-primary mt-3" />
                    </form>
                ) : (
                    <div>Loading...</div>
                )}
            </div>
        );
    }
};