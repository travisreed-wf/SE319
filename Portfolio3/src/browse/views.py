import flask
from flask import flash
from flask import redirect
from flask import render_template
from flask import url_for
from flask.views import MethodView
import models
import re
import json


class BrowseView(MethodView):

    def get(self):
        l = []
        items=models.Item.query.all()
        for item in items:
            l.append((item, models.Thumbnail.query.filter_by(id=item.thumbnail_id).first()))
        return render_template('browse.html',items_and_thumbs=l)

    def post(self):
        name = flask.request.form.get('title')
        desc = flask.request.form.get("description")
        f = flask.request.files.get('file_path')
        print name, desc, f
        return "Successful"

