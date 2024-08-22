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
    ('About Page', 'about', '<div class="row"><p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto dolore laudantium ullam, neque, quas iste eum enim, nihil vitae molestiae quisquam minus iure eveniet et ratione porro corrupti quis asperiores.</p> <img class="img-fluid" src="/media/img/our_company.webp" alt="Our company in Kyiv"><p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet tenetur temporibus enim laborum possimus, soluta tempore praesentium, reprehenderit, nulla voluptatum magnam facilis distinctio repudiandae sit ullam. Placeat nulla quasi saepe?</p></div><div class="row justify-content-center"><div class="col-3"><div class="card"><img class="card-img-top" src="/media/img/our_people.webp" alt="Our people"><div class="card-header bg-dark text-white"><h5 class="card-title text-center ">Head mananger</h5></div><div class="card-body bg-secondary text-white"><p class="card-text">Petro Sagaydachni</p><p class="card-text">Over 20 years of experience in the field of selling cellular communication devices and implementing new communication systems in large companies worldwide</p></div></div></div></div>')
;

-- HELPER
SELECT * FROM pages;

UPDATE pages SET content = '<p class="lead">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nam animi sint provident molestiae voluptate tenetur quae at porro fugit quidem! Repellat culpa quis inventore placeat in illum numquam vitae adipisci? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Perspiciatis reiciendis aperiam, deserunt vel nisi voluptatibus illum exercitationem, expedita, assumenda unde autem in ab quos. Expedita porro alias earum nihil quidem!</p><p>Lorem ipsum dolor, <a href="#">sit amet consectetur</a> adipisicing elit. Nam animi sint provident molestiae voluptate tenetur quae at porro fugit quidem! Repellat culpa quis inventore placeat in illum numquam vitae adipisci?</p><div class="row my-3"><div class="col-sm-6"><img class="img-thumbnail" src="http://picsum.photos/500/500" alt="Some picture"></div><div class="col-sm-6"><h2>Lorem ipsum dolor sit</h2><p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Autem nostrum voluptatibus velit maxime perspiciatis nihil facilis tempora ullam enim repudiandae! Nihil laborum eaque doloremque facere obcaecati? Ipsam, praesentium quas. Quod? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Iure delectus error molestias debitis corrupti fugiat eos repellendus, nostrum, incidunt repudiandae pariatur illo, cupiditate tenetur modi. Voluptatem molestias expedita nisi iure.</p><button class="btn btn-secondary my-3" type="button">Details</button></div></div>'
    WHERE page_id = 1
;


--<p class="lead">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nam animi sint provident molestiae voluptate tenetur quae at porro fugit quidem! Repellat culpa quis inventore placeat in illum numquam vitae adipisci? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Perspiciatis reiciendis aperiam, deserunt vel nisi voluptatibus illum exercitationem, expedita, assumenda unde autem in ab quos. Expedita porro alias earum nihil quidem!</p><p>Lorem ipsum dolor, <a href="#">sit amet consectetur</a> adipisicing elit. Nam animi sint provident molestiae voluptate tenetur quae at porro fugit quidem! Repellat culpa quis inventore placeat in illum numquam vitae adipisci?</p><div class="row my-3"><div class="col-sm-6"><img class="img-thumbnail" src="http://picsum.photos/500/500" alt="Some picture"></div><div class="col-sm-6"><h2>Lorem ipsum dolor sit</h2><p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Autem nostrum voluptatibus velit maxime perspiciatis nihil facilis tempora ullam enim repudiandae! Nihil laborum eaque doloremque facere obcaecati? Ipsam, praesentium quas. Quod? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Iure delectus error molestias debitis corrupti fugiat eos repellendus, nostrum, incidunt repudiandae pariatur illo, cupiditate tenetur modi. Voluptatem molestias expedita nisi iure.</p><button class="btn btn-secondary my-3" type="button">Details</button></div></div>