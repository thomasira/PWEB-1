

<main>
    <header>
        <h2>Edit Stamp</h2>
    </header>
    <form action="{{ path }}stamp/update" method="post" class="form-stamp">
        <section>
            <label>Name:
                <input type="text" name="name" value="{{ stamp.name }}"required>
                <span class="error">{{ errors.name }}</span>
            </label>
            <label>Origin:
                <input type="text" name="origin" value="{{ stamp.origin }}">
                <span class="error">{{ errors.origin }}</span>
            </label>
            <label>Year:
                <input type="year" name="year" value="{{ stamp.year }}">
                <span class="error">{{ errors.year }}</span>
            </label>
            </label>
            <label>Aspect:
                <select name="aspect_id">
                    {% for aspect in aspects %}
                    <option value="{{ aspect.id }}"
                    {% if aspect.selected %}
                    {{ "selected" }}
                    {% endif %}>
                    {{ aspect.aspect }}</option>
                    {% endfor %}
                </select>
            </label>
            <label>description:
                <textarea name="description" cols="30" rows="10">{{ stamp.description }}</textarea>
                <span class="error">{{ errors.description }}</span>
            </label>
            {% if session.privilege_id < 2 %}
            <label>User
                <select name="customer_user_id">
                {% for customer in customers %}
                        <option value="{{ customer.user_id }}">{{ customer.name }}</option>
                {% endfor %}
                </select>
            </label>
            {% endif %}
            <input type="hidden" name="id" value="{{ stamp.id }}">
            <input type="submit" value="edit" class="button">
        </section>

        <section>
            <div>
                <h4>choose from our categories</h4>
                <div>
                    {% for category in categories %}
                        <input type="checkbox" name="category_id[{{ category.id }}]" value="1"
                        {% if category.checked %} {{ "checked" }}
                        {% endif %} id="category_id{{ category.id }}">
                        <label for="category_id{{ category.id }}" class="item-category">{{ category.category }}</label>
                    {% endfor %}
                </div>
            </div>
            <div>
                <h4>And/Or add your own categories(up to 5, you can add more by editing your stamps)</h4>

                <label>
                    <input type="text" name="new_categories[0]">
                    <span class="error">{{ errors.categories_0 }}</span>
                </label>
                <label>
                    <input type="text" name="new_categories[1]">
                    <span class="error">{{ errors.categories_1 }}</span>
                </label>
                <label>
                    <input type="text" name="new_categories[2]">
                    <span class="error">{{ errors.categories_2 }}</span>
                </label>
                <label>
                    <input type="text" name="new_categories[3]">
                    <span class="error">{{ errors.categories_3 }}</span>
                </label>
                <label>
                    <input type="text" name="new_categories[4]">
                    <span class="error">{{ errors.categories_4 }}</span>
                </label>
            </div>
        </section>
    </form>
        

</main>
