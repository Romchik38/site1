CREATE table pages 
(
    page_id serial PRIMARY KEY, 
    name text,
    url text UNIQUE,
    content text
);

INSERT INTO pages (name, url, content)
    VALUES
    ('Main Page of the site', 'index', '<p>Wellcome to our site. We are the best.</p>'),
    ('About Page', 'about', '<p>We sell smartphones for 20 years. Located in Ukraine.</p><p>Contacts: site@site1.com</p>')
;

-- HELPER
SELECT * FROM pages;

UPDATE pages SET content = '<p class="lead">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nam animi sint provident molestiae voluptate tenetur quae at porro fugit quidem! Repellat culpa quis inventore placeat in illum numquam vitae adipisci? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Perspiciatis reiciendis aperiam, deserunt vel nisi voluptatibus illum exercitationem, expedita, assumenda unde autem in ab quos. Expedita porro alias earum nihil quidem!</p><p>Lorem ipsum dolor, <a href="#">sit amet consectetur</a> adipisicing elit. Nam animi sint provident molestiae voluptate tenetur quae at porro fugit quidem! Repellat culpa quis inventore placeat in illum numquam vitae adipisci?</p><div class="row my-3"><div class="col-sm-6"><img class="img-thumbnail" src="http://picsum.photos/500/500" alt="Some picture"></div><div class="col-sm-6"><h2>Lorem ipsum dolor sit</h2><p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Autem nostrum voluptatibus velit maxime perspiciatis nihil facilis tempora ullam enim repudiandae! Nihil laborum eaque doloremque facere obcaecati? Ipsam, praesentium quas. Quod? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Iure delectus error molestias debitis corrupti fugiat eos repellendus, nostrum, incidunt repudiandae pariatur illo, cupiditate tenetur modi. Voluptatem molestias expedita nisi iure.</p><button class="btn btn-secondary my-3" type="button">Details</button></div></div>'
    WHERE page_id = 1
;


--<p class="lead">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nam animi sint provident molestiae voluptate tenetur quae at porro fugit quidem! Repellat culpa quis inventore placeat in illum numquam vitae adipisci? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Perspiciatis reiciendis aperiam, deserunt vel nisi voluptatibus illum exercitationem, expedita, assumenda unde autem in ab quos. Expedita porro alias earum nihil quidem!</p><p>Lorem ipsum dolor, <a href="#">sit amet consectetur</a> adipisicing elit. Nam animi sint provident molestiae voluptate tenetur quae at porro fugit quidem! Repellat culpa quis inventore placeat in illum numquam vitae adipisci?</p><div class="row my-3"><div class="col-sm-6"><img class="img-thumbnail" src="http://picsum.photos/500/500" alt="Some picture"></div><div class="col-sm-6"><h2>Lorem ipsum dolor sit</h2><p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Autem nostrum voluptatibus velit maxime perspiciatis nihil facilis tempora ullam enim repudiandae! Nihil laborum eaque doloremque facere obcaecati? Ipsam, praesentium quas. Quod? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Iure delectus error molestias debitis corrupti fugiat eos repellendus, nostrum, incidunt repudiandae pariatur illo, cupiditate tenetur modi. Voluptatem molestias expedita nisi iure.</p><button class="btn btn-secondary my-3" type="button">Details</button></div></div>