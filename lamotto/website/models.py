import sys
from django.db import models
from django.utils import timezone
from datetime import date
from django.core.validators import MinValueValidator, MaxValueValidator
from PIL import Image
from io import BytesIO
from django.core.files.uploadedfile import InMemoryUploadedFile

# Create your models here.
def years_number_min(last):
    return date.today().year - last

def years_number_max(max):
    return date.today().year + max

class Manufacture(models.Model):
    name = models.CharField(max_length=200)

    def __str__(self):
        return self.name

class Client(models.Model):
    name = models.CharField(max_length=200)
    last_name = models.CharField(max_length=200)
    license_plate = models.CharField(max_length=200)
    brand = models.CharField(max_length=200)
    line = models.CharField(max_length=200)
    cylinder_head = models.CharField(max_length=200)
    manufacturer = models.ForeignKey(Manufacture, on_delete=models.CASCADE)
    email = models.EmailField(max_length=70, null=True, blank=True, unique=True)
    created_date = models.DateTimeField(default=timezone.now)
    model_date = models.IntegerField(default=date.today().year, validators=[MaxValueValidator(years_number_max(1)), MinValueValidator(years_number_min(20))] )
    uploadedImage =  models.ImageField(upload_to = 'Upload/',blank=False,null=True)

    def save(self, *args, **kwargs):
        if not self.id:
            self.uploadedImage = self.compressImage(self.uploadedImage)
        super(Client, self).save(*args, **kwargs)

    @staticmethod
    def compressImage(uploadedImage):
        imageTemproary = Image.open(uploadedImage)
        outputIoStream = BytesIO()
        imageTemproaryResized = imageTemproary.resize( (1020,573) )
        imageTemproary.save(outputIoStream , format='JPEG', quality=60)
        outputIoStream.seek(0)
        uploadedImage = InMemoryUploadedFile(outputIoStream,'ImageField', "%s.jpg" % uploadedImage.name.split('.')[0], 'image/jpeg', sys.getsizeof(outputIoStream), None)
        return uploadedImage



    def __str__(self):
        return self.name


