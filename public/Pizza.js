class Pizza extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            pizzaid: props.match.params.id,
            pizza: null,
            name: ''
        };

        this.handleNameChange = this.handleNameChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    componentDidMount() {
        if (this.state.pizzaid) {
            axios.get('/pizza/' + this.state.pizzaid).then(res => {
                this.setState({
                    pizza: res.data,
                    name: res.data.name
                });
            });
        }
    }

    handleNameChange(event) {
        this.setState({name: event.target.value});
    }

    handleSubmit(event) {
        event.preventDefault();
        var bodyFormData = new FormData();
        bodyFormData.append('name', this.state.name);

        if (this.state.pizzaid) {
            axios({
                method: 'post',
                url: '/pizza/' + this.state.pizzaid,
                data: bodyFormData,
            }).then(res => {
                this.props.history.push('/pizzas');
            });
        } else {
            axios({
                method: 'post',
                url: '/pizza',
                data: bodyFormData,
            }).then(res => {
                this.props.history.push('/pizzas');
            });
        }
    }

    render() {
        const pizza = this.state.pizza;
        const pizzaid = this.state.pizzaid;
        return (
            <div className="container">
                {pizza || !pizzaid ? (
                    <form onSubmit={this.handleSubmit}>
                        <div>
                            <label htmlFor="name-input" className="form-label">Name</label>
                            <input id="name-input" className="form-control" type="text" name="name" value={this.state.name} onChange={this.handleNameChange} />
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