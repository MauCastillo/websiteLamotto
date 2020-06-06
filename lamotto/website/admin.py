from django.contrib import admin
from .home.models import Client, Manufacture
# Register your models here.

admin.site.register(Client)
admin.site.register(Manufacture)
